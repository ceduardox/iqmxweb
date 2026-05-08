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
var indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
var dataBase = null;
function iniciobase() {
    if (!indexedDB) {
        alert("Su navegador no soporta una versión estable de indexedDB. Tal y como las características no serán validas");
    }
    createDataBase();
}
function populateDB() {
    var games = [{ "idj": 1, "descripcion": "Percepción rápida de números", "semana": "1", "codigo": "prn" },
    { "idj": 2, "descripcion": "Ampliación del campo de reconocimiento visual", "semana": "1", "codigo": "acrv" },
    { "idj": 3, "descripcion": "Percepción rápida de palabras", "semana": "1", "codigo": "prp" },
    { "idj": 4, "descripcion": "Percepción rápida de palabras", "semana": "2", "codigo": "prp" },
    { "idj": 5, "descripcion": "Perciba las diferencias", "semana": "2", "codigo": "pd" },
    { "idj": 6, "descripcion": "Lectura visión periférica", "semana": "2", "codigo": "lvp" },
    { "idj": 7, "descripcion": "Gimnasia visual", "semana": "2", "codigo": "gv" },
    { "idj": 8, "descripcion": "Percepción rápida de palabras", "semana": "3", "codigo": "prp" },
    { "idj": 9, "descripcion": "Perciba las diferencias", "semana": "3", "codigo": "pd" },
    { "idj": 10, "descripcion": "Lectura visión periférica", "semana": "3", "codigo": "lvp" },
    { "idj": 11, "descripcion": "Percepción amplitud de campo y agilidad visual", "semana": "3", "codigo": "paca" },
    { "idj": 12, "descripcion": "Bloqueo fono articulador", "semana": "3", "codigo": "bfa" },
    { "idj": 13, "descripcion": "Lectura aceleración máxima", "semana": "3", "codigo": "lam" },
    { "idj": 14, "descripcion": "Percepción rápida de palabras", "semana": "4", "codigo": "prp" },
    { "idj": 15, "descripcion": "Perciba las diferencias", "semana": "4", "codigo": "pd" },
    { "idj": 16, "descripcion": "Lectura visión periférica", "semana": "4", "codigo": "lvp" },
    { "idj": 17, "descripcion": "Percepción rápida de números", "semana": "4", "codigo": "prn" }]
    return games;
}
function insertarptje(des, s, n, f, h, c, t, vl) {
    contarRegistroByNivel("prn", 1 + "", n + "", f, h, c, t, vl);
}
function contarRegistro(des, s, n, f, h, c, t, vl) {
    var dbx = indexedDB.open("IqmaxModI", 1);
    dbx.onsuccess = function () {
        var dbResult = dbx.result;
        var trans = dbResult.transaction(["puntaje"], "readwrite");
        var store = trans.objectStore("puntaje");
        var request = store.count();
        var size_ = 0;
        request.onsuccess = function () {
            size_ = request.result;
        };
        request.onerror = function (e) {
            console.log("Error en ls Base de Datos: ", e);
        };
        trans.oncomplete = function (e) {
            dbx.result.close();
            if (size_ >= 10) {
                obtenerPrimerRegistro();
            }
            insertarPuntaje(des, s, n, f, h, c, t, vl);
        };
    };
}
function contarRegistroByNivel(des, s, n, f, h, c, t, vl) {
    var dbx = indexedDB.open("IqmaxModI", 1);
    dbx.onsuccess = function () {
        var dbResult = dbx.result;
        var trans = dbResult.transaction(["puntaje"], "readwrite");
        var store = trans.objectStore("puntaje");
        var index = store.index('idj',);
        var request = index.openCursor(IDBKeyRange.only(des));
        var countRow = 0;
        request.onsuccess = function (e) {
            var result = request.result;
            if (result) {
                if (result.value.nivel == n && result.value.semana == s) {
                    countRow++;
                }
                result.continue();
            }
        }
        trans.oncomplete = function (e) {
            dbx.result.close();
            if (countRow >= 10) {
                obtenerPrimerRegistroPorNivel(n, s, des);
            }
            insertarPuntaje(des, s, n, f, h, c, t, vl);
        };
        request.onerror = function (e) {
            console.log("Error en ls Base de Datos: ", e);
        };
    };
}
function insertarPuntaje(des, s, n, f, h, c, t, vl) {
    var dbx = indexedDB.open("IqmaxModI", 1);
    dbx.onsuccess = function () {
        var dbResult = dbx.result;
        var trans = dbResult.transaction(["puntaje"], "readwrite");
        var store = trans.objectStore("puntaje");
        var ptje = {
            fecha: f,
            hora: h,
            cant: c,
            tiempo: t,
            velocidad: vl,
            nivel: n,
            idj: des,
            semana: s,
        };
        var request = store.put(ptje);
        request.onsuccess = function () {
            console.log('put got generated key: ' + request.result);
        };
        trans.oncomplete = function (e) {
            dbx.result.close();
        };
        request.onerror = function (e) {
            console.log("Error al momento de adicionar el puntaje: ", e);
        };
    };
};
function obtenerPrimerRegistro() {
    var dbx = indexedDB.open("IqmaxModI", 1);
    dbx.onsuccess = function () {
        var dbResult = dbx.result;
        var trans = dbResult.transaction(["puntaje"], "readwrite");
        var store = trans.objectStore("puntaje");
        var request = store.openCursor();
        var key = undefined;
        request.onsuccess = function (e) {
            var result = e.target.result;
            if (!!result == false) {
                return;
            }
            key = result.key;
        };
        request.onerror = function (e) {
            console.log("Error en ls Base de Datos: ", e);
        };
        trans.oncomplete = function (e) {
            dbx.result.close();
            eliminarRegistro(key);
        };
    };
}
function obtenerPrimerRegistroPorNivel(niv, sem, des) {
    var dbx = indexedDB.open("IqmaxModI", 1);
    dbx.onsuccess = function () {
        var dbResult = dbx.result;
        var trans = dbResult.transaction(["puntaje"], "readwrite");
        var store = trans.objectStore("puntaje");
        var index = store.index("idj");
        var request = index.openCursor(IDBKeyRange.only(des));
        var keyRow = '';
        request.onsuccess = function (e) {
            var result = request.result;
            if (result) {
                if (result.value.nivel == niv && result.value.semana == sem) {
                    keyRow = result.value.idp;
                    return;
                } else {
                    result.continue();
                }
            }
        }
        request.onerror = function (e) {
            console.log("Error en ls Base de Datos: ", e);
        };
        trans.oncomplete = function (e) {
            dbx.result.close();
            eliminarRegistro(keyRow);
        };
    };
}
function eliminarRegistro(id) {
    var dbx = indexedDB.open("IqmaxModI", 1);
    dbx.onsuccess = function () {
        var dbResult = dbx.result;
        var trans = dbResult.transaction(["puntaje"], "readwrite");
        var store = trans.objectStore("puntaje");
        var request = store.delete(id);
        request.onerror = function (e) {
            console.log("Error en ls Base de Datos: ", e);
        };
        trans.oncomplete = function (e) {
            dbx.result.close();
        };
    };
}
function obtenerPuntaje(semana, description, nivel) {
    var dbx = indexedDB.open("IqmaxModI");
    dbx.onsuccess = function (e) {
        var dbResult = e.target.result;
        var trans = dbResult.transaction(["puntaje"], "readonly");
        var store = trans.objectStore("puntaje");
        var index = store.index("idj");
        var request = index.openCursor(IDBKeyRange.only(description));
        var puntaje = [];
        request.onsuccess = function (e) {
            var result = request.result;
            if (result) {
                if (result.value.nivel == nivel && result.value.semana == semana) {
                    puntaje.push(result.value);
                }
                result.continue();
            }
        }
        trans.oncomplete = function (e) {
            dbx.result.close();
            mostrarDatos(puntaje);
        };
        request.onerror = function (e) {
            console.log("Error en ls Base de Datos: ", e);
        };
    };
}
function consulta_grafica(nom, sem, niv) {
    sbd = sem;
    nbd = niv;
    obtenerPuntaje("1", "prn", niv + "");
}
function mostrarDatos(results) {
    lg_graf = results.length;
    cerear();
    $("#tbody-grafica").empty();
    for (var i = 0; i < lg_graf; i++) {
        $("#tbody-grafica").append(
            '<tr>' +
            '<th scope="row">' + (i + 1) + '</th>' +
            '<td >' + results[i].fecha + ' ' + results[i].hora + '</td>' +
            '<td >' + results[i].tiempo + '</td>' +
            '<td >' + results[i].cant + '</td>' +
            '</tr>'
        );
        pal[i] = parseInt(results[i].cant);
    }
    graficar();
}
function cerear() {
    min = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    pal = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
}
function urls(s, c) {
}
function createDataBase() {
    if (!dataBase) {
        dataBase = indexedDB.open("IqmaxModI", 1);
        dataBase.onupgradeneeded = function (e) {
            var db = dataBase.result;
            let objectGameStore = db.createObjectStore("juego", { keyPath: "idj", autoIncrement: true });
            objectGameStore.createIndex("descripcion", "descripcion", { unique: false });
            objectGameStore.createIndex("semana", "semana", { unique: false });
            objectGameStore.createIndex("codigo", "codigo", { unique: false });
            let objectScoreStore = db.createObjectStore("puntaje", { keyPath: "idp", autoIncrement: true });
            objectScoreStore.createIndex("cant", "cant", { unique: false });
            objectScoreStore.createIndex("tiempo", "tiempo", { unique: false });
            objectScoreStore.createIndex("fecha", "fecha", { unique: false });
            objectScoreStore.createIndex("hora", "hora", { unique: false });
            objectScoreStore.createIndex("nivel", "nivel", { unique: false });
            objectScoreStore.createIndex("velocidad", "velocidad", { unique: false });
            objectScoreStore.createIndex("idj", "idj", { unique: false });
            objectScoreStore.createIndex("semana", "semana", { unique: false });
        };
        dataBase.onsuccess = function (e) {
            dataBase.result.close();
            createData();
        };
        dataBase.onerror = function (e) {
            alert("Error al procesar la Base de Datos. " + e);
        };
    }
}
function createData() {
    dataBase = indexedDB.open("IqmaxModI", 1);
    dataBase.onsuccess = function () {
        var dbResult = dataBase.result;
        var trans = dbResult.transaction(["juego"], "readwrite");
        var store = trans.objectStore("juego");
        let gamesData = populateDB();
        for (var item in gamesData) {
            var request = store.put(gamesData[item]);
            request.onerror = function (e) {
                console.log("Error Adding: ", e);
            };
        }
        trans.oncomplete = function (e) {
            dataBase.result.close();
        };
        request.onerror = function (e) {
            console.log("Error Adding: ", e);
        };
    };
    dataBase.onerror = function (e) {
        alert("Error al procesar la Base de Datos. " + e);
    };
};