var bd, codj,
    codp,
    detalle;
var nbd, fbd,
    hbd, cbd,
    tbd, sbd,
    vlbd;
var cont, len, lg_graf;
var min = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var pal = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var min2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var pal2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var min3 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var pal3 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
function iniciobase() {
    bd = openDatabase('citex10', '1.0', 'citexb', 500000);
    if (bd) {
        bd.transaction(populateDB, onErrorDB, onSuccessDB);
    }
    else {
        console.log("Error al crear base de datos");
    }
}
function populateDB(tx) {
    tx.executeSql('CREATE TABLE IF NOT EXISTS usuario (idu INTEGER PRIMARY KEY AUTOINCREMENT, nombre VARCHAR(50) NOT NULL, apellido VARCHAR (50) NOT NULL,user VARCHAR (50) NOT NULL,pass VARCHAR (50) NOT NULL, actual TEXT,estado TEXT);');
    tx.executeSql('CREATE TABLE IF NOT EXISTS juego   (idj INTEGER PRIMARY KEY AUTOINCREMENT, descripcion VARCHAR(50) NOT NULL, semana TEXT,codigo VARCHAR(10) NOT NULL);');
    tx.executeSql('CREATE TABLE IF NOT EXISTS puntaje (idp INTEGER PRIMARY KEY AUTOINCREMENT, cant INTEGER, tiempo INTEGER,fecha VARCHAR(20) NOT NULL,hora VARCHAR(20) NOT NULL,nivel INTEGER,velocidad VARCHAR(20) NOT NULL,idj INTEGER,idu INTEGER);');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (1,"Percepción rápida de números","1","prn")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (2,"Ampliación del campo de reconocimiento visual","1","acrv")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (3,"Percepción rápida de palabras","1","prp")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (4,"Percepción rápida de palabras","2","prp")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (5,"Perciba las diferencias","2","pd")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (6,"Lectura visión periférica","2","lvp")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (7,"Gimnasia visual","2","gv")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (8,"Percepción rápida de palabras","3","prp")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (9,"Perciba las diferencias","3","pd")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (10,"Lectura visión periférica","3","lvp")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (11,"Percepción amplitud de campo y agilidad visual","3","paca")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (12,"Bloqueo fono articulador","3","bfa")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (13,"Lectura aceleración máxima","3","lam")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (14,"Percepción rápida de palabras","4","prp")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (15,"Perciba las diferencias","4","pd")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (16,"Lectura visión periférica","4","lvp")');
    tx.executeSql('INSERT INTO juego (idj, descripcion,semana,codigo) VALUES (17,"Percepción rápida de números","4","prn")');
    //tx.executeSql('INSERT INTO puntaje (idj, cant,tiempo,fecha,hora,nivel,velocidad,idj,idu) VALUES (1,"2","3","4","5","6","7",8,9)');
}
function onErrorDB(err) {
    console.log('Error processing SQL: ' + err.code);
}
function onSuccessDB(argument) {
    bd = openDatabase('citex10', '1.0', 'citexb', 500000);
}
function insertarptje(des, s, n, f, h, c, t, vl) {
    nbd = n; fbd = f; hbd = h; cbd = c; tbd = t; vlbd = vl;
    bd.transaction(function (tx) {
        tx.executeSql('SELECT * FROM juego WHERE codigo="' + des + '" and semana="' + s + '"', [], obtiene_id_juego, onErrorDB);
    })
}
function obtiene_id_juego(tx, results) {
    len = results.rows.length;
    //obtenemos el id 
    codj = results.rows.item(0).idj;
    consulta_contar(codj);
}
function consulta_contar(codj) {
    //alert(codj+"-°-"+nbd);
    bd.transaction(function (tx) {
        tx.executeSql('SELECT * FROM puntaje WHERE idj="' + codj + '" and nivel="' + nbd + '" ', [], obtiene_total, onErrorDB);
    })
}
function obtiene_total(tx, results) {
    cont = results.rows.length;
    if (cont != 0) {
        codp = results.rows.item(0).idp;
    }
    insertar_puntaje(cont);
}
function insertar_puntaje(cont) {
    if (cont < 10) {
        bd.transaction(function (tx) {
            tx.executeSql('INSERT INTO puntaje (cant,tiempo,fecha,hora,nivel,velocidad,idj,idu) VALUES (?,?,?,?,?,?,?,?)', [cbd, tbd, fbd, hbd, nbd, 'a', codj, 1]);
        });
    }
    else {
        elimina(codp);
        bd.transaction(function (tx) {
            tx.executeSql('INSERT INTO puntaje (cant,tiempo,fecha,hora,nivel,velocidad,idj,idu) VALUES (?,?,?,?,?,?,?,?)', [cbd, tbd, fbd, hbd, nbd, 'a', codj, 1]);
        });
    }
}
function elimina(cod) {
    bd.transaction(function (tx) {
        tx.executeSql('DELETE  FROM puntaje WHERE idp="' + cod + '"', [], mostrar, onErrorDB);
    })
}
function mostrar(tx, results) {
    // body...
}
//consulta de grafica
function consulta_grafica(nom, sem, niv) {
    //nbd=nom;
    sbd = sem;
    nbd = niv;
    bd.transaction(function (tx) {
        tx.executeSql('SELECT * FROM juego WHERE codigo="' + nom + '" and semana="' + sem + '"', [], obt_id_juego, onErrorDB);
    })
}
function obt_id_juego(tx, results) {
    len = results.rows.length;
    //obtenemos el id 
    codj = results.rows.item(0).idj;
    $('#juego').text(results.rows.item(0).descripcion);
    obtener_ptjes(codj);
}
function obtener_ptjes(codj) {
    bd.transaction(function (tx) {
        tx.executeSql('SELECT * FROM puntaje WHERE idj="' + codj + '" and nivel="' + nbd + '"', [], mostrar_datos, onErrorDB);
    })
}
function mostrar_datos(tx, results) {
    lg_graf = results.rows.length;
    cerear();
    $("#tbody-grafica").empty();
    for (var i = 0; i < lg_graf; i++) {
        $("#tbody-grafica").append(
            '<tr>' +
            '<th scope="row">' + (i + 1) + '</th>' +
            '<td >' + results.rows.item(i).fecha + ' ' + results.rows.item(i).hora + '</td>' +
            '<td >' + results.rows.item(i).tiempo + '</td>' +
            '<td >' + results.rows.item(i).cant + '</td>' +
            '</tr>'
        );
        pal[i] = parseInt(results.rows.item(i).cant);
        //min[i]=parseInt(results.rows.item(i).tiempo);
    }
    graficar();
}
function cerear() {
    min = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    pal = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
}
url = [{ "semana": "1", "cod": "prn", "pag": "percepcion-s1.html" },
{ "semana": "1", "cod": "acrv", "pag": "visual.html" },
{ "semana": "1", "cod": "prp", "pag": "palabras.html" },
{ "semana": "2", "cod": "prp", "pag": "percepcion.html?s=2" },
{ "semana": "2", "cod": "pd", "pag": "diferencia.html?s=2" },
{ "semana": "2", "cod": "lvp", "pag": "adivinanza.html" },
{ "semana": "2", "cod": "gv", "pag": "laberinto.html" },
{ "semana": "3", "cod": "prp", "pag": "percepcion.html?s=3" },
{ "semana": "3", "cod": "pd", "pag": "diferencia.html?s=3" },
{ "semana": "3", "cod": "lvp", "pag": "lectura.html?s=3" },
{ "semana": "3", "cod": "paca", "pag": "percepcionAmplitud.html" },
{ "semana": "4", "cod": "prp", "pag": "percepcion.html?s=4" },
{ "semana": "4", "cod": "pd", "pag": "diferencia.html?s=4" },
{ "semana": "4", "cod": "lvp", "pag": "lectura.html?s=4" },
{ "semana": "4", "cod": "prn", "pag": "numeros.html" },];
function urls(s, c) {
    pag = "";
    //alert(url);
    for (var i = 0; i < url.length; i++) {
        if (url[i].semana == s && url[i].cod == c)
            pag = url[i].pag;
    }
    return pag;
}
