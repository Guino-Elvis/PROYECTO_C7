const puppeteer = require('puppeteer');
const randomUseragent = require('random-useragent');
const db = require('./db'); // Importa la conexión a la base de datos
const moment = require('moment');

// Convertir la fecha al formato deseado
const convertirFecha = (fecha) => {
    return moment(fecha, 'DD-MM-YYYY').format('YYYY-MM-DD');
};

// Función para agregar un retraso entre procesos
const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

// Insertar datos en la base de datos
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

// Procesar una página específica
const processPage = async (page, url) => {
    console.log('Visitando página ==>', url);
    await page.goto(url, { waitUntil: 'networkidle2' });

    // Espera a que se cargue el contenido principal
    const jobSelector = '.sc-cyVxgd'; // Cambia esto según el selector adecuado de la página
    try {
        await page.waitForSelector(jobSelector, { timeout: 5000 }); // Espera un máximo de 5 segundos
    } catch (error) {
        console.log(`No se encontraron resultados en la página ${url}. Deteniendo...`);
        return false; // Si no se encuentra el selector, detiene el bucle
    }

    const listaDeItems = await page.$$('.sc-jYIdPM');
    let pageData = [];  // Aquí almacenamos los datos individuales de cada página

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

        // Almacena los datos individuales en el array de datos de la página
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

    // Inserta los datos obtenidos de la página en la base de datos
    await insertDataIntoDB(pageData);
    console.log(`Datos de la página ${url} insertados en la base de datos.`);

    await delay(2000); // Espera 2 segundos antes de procesar el siguiente ítem

    return true; // Si todo salió bien, devolvemos true para continuar
};

// Función principal para inicializar el proceso
const initialization = async () => {
    const browser = await puppeteer.launch({
        headless: true, // Ejecutar en modo "headless"
        ignoreHTTPSErrors: true
    });

    const page = await browser.newPage();
    const header = randomUseragent.getRandom((ua) => ua.browserName === 'Firefox');
    await page.setUserAgent(header);
    await page.setViewport({ width: 1920, height: 1080 });

    let pageNumber = 1;
    let hasMorePages = true;

    // Bucle para seguir procesando páginas mientras haya resultados
    while (hasMorePages) {
        const currentUrl = `https://www.bumeran.com.pe/empleos.html?page=${pageNumber}`;
        hasMorePages = await processPage(page, currentUrl);

        if (hasMorePages) {
            pageNumber++; // Incrementa el número de página si hay más
        } else {
            console.log('No se encontraron más páginas para procesar.');
        }
    }

    await page.close();
    await browser.close();
    db.end(); // Cierra la conexión a la base de datos
};

initialization();
