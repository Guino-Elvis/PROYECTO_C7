const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors'); // Importa cors
const puppeteer = require('puppeteer');
const randomUseragent = require('random-useragent');
const db = require('./db'); // Importa la conexión a la base de datos
const moment = require('moment');

const app = express();

// Configura CORS para permitir solicitudes desde cualquier origen
app.use(cors());

app.use(bodyParser.json()); // Asegúrate de usar el middleware para manejar JSON
app.use(express.static('public')); // Servir archivos estáticos como HTML

const convertirFecha = (fecha) => {
    return moment(fecha, 'DD-MM-YYYY').format('YYYY-MM-DD');
};

const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

const insertDataIntoDB = async (data) => {
    const query = `
        INSERT INTO oferta_laborals (titulo, ubicacion, remuneracion, descripcion, body, fecha_inicio, fecha_fin, limite_postulante, state, empresa_id, user_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `;
    const insertPromises = data.map((row) => {
        const values = [
            row.titulo,
            row.ubicacion,
            row.remuneracion,
            row.descripcion,
            row.body,
            row.fecha_inicio,
            row.fecha_fin,
            row.limite_postulante,
            row.state,
            row.empresa_id,
            row.user_id
        ];
        return new Promise((resolve, reject) => {
            db.query(query, values, (err) => {
                if (err) {
                    console.error('Error insertando datos:', err);
                    reject(err);
                } else {
                    console.log('Datos insertados con éxito');
                    resolve();
                }
            });
        });
    });
    await Promise.all(insertPromises);
};

const processPage = async (page, url) => {
    console.log('Visitando página ==>', url);
    await page.goto(url, { waitUntil: 'networkidle2' });

    const jobSelector = '.sc-cyVxgd'; // Cambia esto según el selector adecuado de la página
    try {
        await page.waitForSelector(jobSelector, { timeout: 5000 });
    } catch (error) {
        console.log(`No se encontraron resultados en la página ${url}. Deteniendo...`);
        return false;
    }

    const listaDeItems = await page.$$('.sc-jYIdPM');
    let pageData = [];

    for (const item of listaDeItems) {
        const titulo = await item.$(".sc-dCVVYJ");
        const ubicacion = await item.$(".sc-LAuEU");
        const remuneracion = await item.$(".dIB.mr10");
        const descripcion = await item.$(".sc-dCVVYJ");
        const body = await item.$(".sc-huKLiJ");
        const fecha_inicio = await item.$(".dIB.mr10");
        const fecha_fin = await item.$(".dIB.mr10");
        const limite_postulante = await item.$(".dIB.mr10");
        const state = await item.$(".dIB.mr10");
        const empresa_id = await item.$(".dIB.mr10");
        const user_id = await item.$(".dIB.mr10");

        const getTitulo = await page.evaluate(el => el ? el.innerText : 'N/A', titulo);
        const getUbicacion = await page.evaluate(el => el ? el.innerText : 'N/A', ubicacion);
        const getRemuneracion = await page.evaluate(el => el ? el.innerText : 's/. 2500', remuneracion);
        const getDescripcion = await page.evaluate(el => el ? el.innerText : 'N/A', descripcion);
        const getBody = await page.evaluate(el => el ? el.innerText : 'N/A', body);
        const getFechaInicio = convertirFecha(await page.evaluate(el => el ? el.innerText : '02-09-2024', fecha_inicio));
        const getFechaFin = convertirFecha(await page.evaluate(el => el ? el.innerText : '15-09-2024', fecha_fin));
        const getLimitePostulante = await page.evaluate(el => el ? el.innerText : 'N/A', limite_postulante);
        const getState = await page.evaluate(el => el ? el.innerText : '2', state);
        const getEmpresaId = await page.evaluate(el => el ? el.innerText : '2', empresa_id);
        const getUserId = await page.evaluate(el => el ? el.innerText : '2', user_id);

        pageData.push({
            titulo: getTitulo,
            ubicacion: getUbicacion,
            remuneracion: getRemuneracion,
            descripcion: getDescripcion,
            body: getBody,
            fecha_inicio: getFechaInicio,
            fecha_fin: getFechaFin,
            limite_postulante: getLimitePostulante,
            state: getState,
            empresa_id: getEmpresaId,
            user_id: getUserId,
        });
    }

    await insertDataIntoDB(pageData);
    console.log(`Datos de la página ${url} insertados en la base de datos.`);

    await delay(2000);

    return true;
};

app.post('/start-scraping', async (req, res) => {
    const { link_web } = req.body;

    console.log('Enlace recibido:', link_web);

    if (!link_web || !link_web.startsWith('https://www.bumeran.com.pe/')) {
        return res.status(400).send('Link incorrecto');
    }

    const browser = await puppeteer.launch({
        headless: true,
        ignoreHTTPSErrors: true
    });

    const page = await browser.newPage();
    const header = randomUseragent.getRandom((ua) => ua.browserName === 'Firefox');
    await page.setUserAgent(header);
    await page.setViewport({ width: 1920, height: 1080 });

    let pageNumber = 1;
    let hasMorePages = true;

    while (hasMorePages) {
        const currentUrl = `${link_web}empleos.html?page=${pageNumber}`;
        console.log('URL actual:', currentUrl);
        hasMorePages = await processPage(page, currentUrl);

        if (hasMorePages) {
            pageNumber++;
        } else {
            console.log('No se encontraron más páginas para procesar.');
        }
    }

    await page.close();
    await browser.close();
    db.end();

    res.send('Scraping completado');
});

app.listen(3000, () => {
    console.log('Servidor escuchando en el puerto 3000');
});
