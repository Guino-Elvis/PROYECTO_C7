const puppeteer = require('puppeteer');
const ExcelJS = require('exceljs');
const randomUseragent = require('random-useragent');
const db = require('./db'); // Importa la conexión a la base de datos
const moment = require('moment');

let count = 0;
let data = [];

const saveExcel = async (data) => {
    const workbook = new ExcelJS.Workbook();
    const fileName = `empleos.xlsx`;
    const sheet = workbook.addWorksheet('Resultados');
    const reColumns = [
        { header: 'Título', key: 'titulo' },
        { header: 'Ubicación', key: 'ubicacion' },
        { header: 'Remuneración', key: 'remuneracion' },
        { header: 'Descripción', key: 'descripcion' },
        { header: 'Body', key: 'body' },
        { header: 'Fecha de Inicio', key: 'fecha_inicio' },
        { header: 'Fecha de Fin', key: 'fecha_fin' },
        { header: 'Límite para Postulantes', key: 'limite_postulante' },
        { header: 'Estado', key: 'state' },
        { header: 'ID de Empresa', key: 'empresa_id' },
        { header: 'ID de Usuario', key: 'user_id' },
    ];
    sheet.columns = reColumns;
    sheet.addRows(data);

    await workbook.xlsx.writeFile(fileName);
    console.log('Creado exitosamente');
};

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

const convertirFecha = (fecha) => {
    return moment(fecha, 'DD-MM-YYYY').format('YYYY-MM-DD');
};

const initialization = async (url = 'https://www.bumeran.com.pe/empleos.html?page=3') => {
    console.log('Vuelta número ==>', count);
    console.log('Visitando página ==>', url);

    if (count > 5) {
        console.log('Chao!! 5 Vueltas realizadas');
        await browser.close();
        db.end(); // Cierra la conexión a la base de datos
        console.log('Proceso finalizado exitosamente.');
        return;
    }

    browser = await puppeteer.launch({
        headless: false,
        ignoreHTTPSErrors: true
    });

    const page = await browser.newPage();
    const header = randomUseragent.getRandom((ua) => ua.browserName === 'Firefox');
    await page.setUserAgent(header);
    await page.setViewport({ width: 1920, height: 1080 });

    await page.goto(url, { waitUntil: 'networkidle2' });
    await page.waitForSelector('#listado-avisos');

    const objectNextButton = await page.$('.andes-pagination__button--next a');
    const getUrl = await page.evaluate(el => el ? el.getAttribute('href') : null, objectNextButton);

    const listaDeItems = await page.$$('.sc-jYIdPM');

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

        data.push({
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

    count++;
    await saveExcel(data);
    await insertDataIntoDB(data);
    await browser.close();

    if (getUrl) {
        initialization(`https://www.bumeran.com.pe/${getUrl}`);
    } else {
        console.log('Proceso finalizado exitosamente.');
        db.end(); // Cierra la conexión a la base de datos
    }
};

initialization();
