const laravel = { URL: "http://localhost:8000/api" }

// === GUARDAR CHAT    ====================================
export async function guardarChatBBDD() {
    const URL = `${laravel.URL}/guardarChat`;
    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id_emisor: 'process', missatge: msg }),
    });
    const data = await response.json();
    return data;
}

// === GUARDAR MISATGES ===================================
export async function guardarMissatgeBBDD(msg) {
    console.log(msg);
    try {
        const URL = `${laravel.URL}/guardarMensaje`;
        const response = await fetch(URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ emisor: msg.emisor, texto: msg.texto, chat_id: msg.chat_id, id_message: msg.id_message, editado: msg.editado}),
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("error: ", error);
    }
}

export async function crearChatBBDD(idAlumne) {
    const URL = `${laravel.URL}/crearChat`;
    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ alumno_id: idAlumne })
    });
    const data = await response.json();
    return data;
}

export async function getChatsBBDD() {
    const URL = `${laravel.URL}/getChats`;
    const response = await fetch(URL, {
        method: 'GET',
    });
    const data = await response.json();
    return data;
}

export async function getChatMessagesBBDD(chat_id, rol_id) {
    const URL = `${laravel.URL}/getChatMessages`;
    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ chat_id: chat_id, rol_id: rol_id })
    });
    const data = await response.json();
    return data;
}

export async function editarMessageBBDD(id_message, id_usuari, textoEditado) {
    const URL = `${laravel.URL}/editMessage`;
    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id_message: id_message, alumno_id: id_usuari, textEdit: textoEditado })
    });
    const data = await response.json();
    return data;
}

// === OBTINDRE TOTS ELS ALUMENS ===========================
export async function getAlumnes() {
    const URL = `${laravel.URL}/get-alumnes`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (!response.ok) {
        const textResponse = await response.text();
        console.error("Error en la solicitud:", response.status, textResponse);
        throw new Error(`Error ${response.status}: ${response.statusText}`);
    }

    const data = await response.json();
    
    if (Array.isArray(data)) {
        return data;
    }       
}

// === OBRIR INFO D'ALUMNE =================================
export const getAlumneById = async (id) => {
    const URL = `${laravel.URL}/alumnes/${id}`;
    const response = await fetch(URL);
    if (!response.ok) throw new Error('Error al obtener el alumno');
    return await response.json();
};

// === INCIDENCIA RELACIONADA AMB ALUMNE ===================
export const alertasAlumne = async (id) => {
    const URL = `${laravel.URL}/user/${id}/alerts`;
    const response = await fetch(URL);
    if (!response.ok) throw new Error ('No s\'han trobat alertes d\'aquest usuari');
    return await response.json();
}

// === ACTUALIZAR DATOS DE UN ALUMNO ========================
export const updateAlumne = async (id, data) => {
    const URL = `${laravel.URL}/alumnes/${id}`;
    const response = await fetch(URL, {
        method: 'POST', // Usamos POST como especificaste
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });

    if (!response.ok) {
        const error = await response.text();
        console.error('Error al actualizar el alumno:', error);
        throw new Error(`Error al actualizar el alumno: ${error}`);
    }

    return await response.json();
};

// === OBTENER ROLES ======================
export const getRoles = async () => {
    const URL = `${laravel.URL}/rol`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) throw new Error('No s\' han pogut trobar els rols');
    return await response.json();
}

// === OBTENER CURSOS =====================
export const getCursos = async () => {
    const URL = `${laravel.URL}/cursos`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) throw new Error('No s\'han pogut trobar els cursos');
    return await response.json();
};

// === OBTENER TORNS =====================
export const getTorns = async () => {
    const URL = `${laravel.URL}/torns`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) throw new Error('No s\'han pogut trobar els torns');
    return await response.json();
};

// === OBTENER COMPAÑEROS CLASE ===========
export const getCompanysClase = async (courseId) => {
    const URL = `${laravel.URL}/companys-clase/${courseId}`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });

    if (!response.ok) {
        const error = await response.text();
        console.error('Error al obtener los compañeros de clase:', error);
        throw new Error(`Error al obtener los compañeros de clase: ${response.statusText}`);
    }

    return await response.json();
};

// === OBTENER PREGUNTAS ==================
export const getPreguntas = async () => {
    const URL = `${laravel.URL}/preguntas`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });

    if (!response.ok) {
        const error = await response.text();
        throw new Error(`Error al obtener las preguntas: ${response.statusText}`);
    }

    return await response.json();
};

// === PUBLICAR RESPUESTAS ENQUESTA =======
export const publicarRespostas = async (data) => {
    try {
        const URL = `${laravel.URL}/publicar-respostas`;
        const response = await fetch(URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ respuestas: data }),
        });

        if (response.ok) {
            return { success: true };
        } else {
            const errorData = await response.json();
            return { success: false, message: errorData.message || 'Error al enviar las respuestas' };
        }
    } catch (error) {
        return { success: false, message: 'Error de conexión' };
    }
};

// === SOLICITAR CAMBIAR PASSWORD =========
export const sendPasswordResetEmail = async (email) => {
    try {
        const response = await fetch(`${laravel.URL}/password/reset/email`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email }),
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Error al enviar el correo');
        }

        return await response.json();
    } catch (error) {
        throw error;
    }
};

// === CAMBIAR PASSWORD ===================
export const resetPassword = async (token, password, password_confirmation) => {
    try {
        const response = await fetch(`${laravel.URL}/password/reset`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ token, password, password_confirmation }),
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Error al restablecer la contraseña');
        }

        return await response.json();
    } catch (error) {
        throw error;
    }
};

// === GET DADES SOCIOGRAMA ===============
export const getAnalisisData = async () => {
    try {
        const response = await fetch(`${laravel.URL}/analisis`);
        return await response.json();
    } catch (error) {
        console.error('Error al obtener los datos de análisis:', error);
        throw error;
    }
};

// === ANALISIS SOCIOGRAMA ================
export const getCompanysClaseSociograma = async (selectedClass) => {
    try {
        const response = await fetch(`${laravel.URL}/companys-clase/${selectedClass}`);
        return await response.json();
    } catch (error) {
        console.error('Error al obtener las compañías de clase:', error);
        throw error;
    }
};

// === PERFIL DADES ALUMNE ================
// === DadesUserComp.vue ==================
export const editarPerfilUser = async (payload) => {
    const URL = `${laravel.URL}/editaruser`;
    try {
        const response = await fetch(URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error al editar el perfil:', errorText);
            throw new Error(`Error ${response.status}: ${response.statusText}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Error a l\'hora d\'actualitzar l\'usuari: ', error);
        throw error;
    }
};



// === EditarAlertaComp.vue ===============
// === OBTENER ALERTA POR ID ===============
export const getAlertById = async (id) => {
    const URL = `${laravel.URL}/show/${id}`;
    try {
        const response = await fetch(URL, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
        });
        if (!response.ok) throw new Error('Error al obtener la alerta');
        return await response.json();
    } catch (error) {
        console.error('Error al obtener la alerta:', error);
        throw error;
    }
};

// === ACTUALIZAR ALERTA ====================
export const updateAlert = async (data) => {
    const URL = `${laravel.URL}/update`;
    try {
        const response = await fetch(URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Error al actualizar la alerta');
        return await response.json();
    } catch (error) {
        console.error('Error al actualizar la alerta:', error);
        throw error;
    }
};


// === EstadisticasComp.vue ==========================
// === OBTENER ALERTAS FILTRADAS =====================
export const getAlertsFilter = async (tiempo, cantidad) => {
    const URL = `${laravel.URL}/getAlertsFilter`;
    try {
        const response = await fetch(URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ time: tiempo, quant: cantidad }),
        });
        if (!response.ok) {
            const errorText = await response.text();
            console.error("Error en getAlertsFilter:", errorText);
            throw new Error(`Error al obtener alertas filtradas: ${errorText}`);
        }
        return await response.json();
    } catch (error) {
        console.error("Error en getAlertsFilter:", error);
        throw error;
    }
};

// === OBTENER TODAS LAS ALERTAS =====================
export const getAllAlerts = async () => {
    const URL = `${laravel.URL}/getAllAlerts`;
    try {
        const response = await fetch(URL, { method: 'GET' });
        if (!response.ok) {
            const errorText = await response.text();
            console.error("Error en getAllAlerts:", errorText);
            throw new Error(`Error al obtener todas las alertas: ${errorText}`);
        }
        return await response.json();
    } catch (error) {
        console.error("Error en getAllAlerts:", error);
        throw error;
    }
};

export async function getAlerts(tiempo, cantidad) {
    try {
        const response = await fetch(`${laravel.URL}/getAlertsFilter`, {
            method: 'POST',
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify({
                time: tiempo,
                quant: cantidad
            })
        });

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }

        const result = await response.json();
        return result;
    } catch (error) {
        console.error("Error fetching alerts: ", error);
        return [];
    }
}






// === SectorAlertasComp.vue ========================

// Obtener información de un usuario por ID
export const getUser = async (alumne_id) => {
    try {
        const response = await fetch(`${laravel.URL}/getUser`, {
            method: 'POST',
            headers: { "Content-type": "application/json" },
            body: JSON.stringify({ alumne_id }),
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error("Error en getUser:", errorText);
            throw new Error(`Error al obtener usuario: ${errorText}`);
        }

        return await response.json();
    } catch (error) {
        console.error("Error en getUser:", error);
        throw error;
    }
};

// Obtener alertas por sector
export const getAlertsSector = async (sector_id) => {
    try {
        const response = await fetch(`${laravel.URL}/getAlertsSector`, {
            method: 'POST',
            headers: { "Content-type": "application/json" },
            body: JSON.stringify({ sector_id }),
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error("Error en getAlertsSector:", errorText);
            throw new Error(`Error al obtener alertas del sector: ${errorText}`);
        }

        return await response.json();
    } catch (error) {
        console.error("Error en getAlertsSector:", error);
        throw error;
    }
};


export const fetchCursos = async () => {
    try {
        const response = await fetch(`${laravel.URL}/cursos`);

        if (!response.ok) {
            const errorText = await response.text();
            console.error("Error en fetchCursos:", errorText);
            throw new Error(`Error al obtener los cursos: ${errorText}`);
        }

        return await response.json();
    } catch (error) {
        console.error("Error en fetchCursos:", error);
        throw error;
    }
};

export const registerUser = async (userData) => {
    try {
        const response = await fetch(`${laravel.URL}/register`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(userData),
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error("Error en registerUser:", errorText);
            throw new Error(`Error al registrar el usuario: ${errorText}`);
        }

        return await response.json();
    } catch (error) {
        console.error("Error en registerUser:", error);
        throw error;
    }
};


export const fetchAlertes = async (usuari_id) => {
    try {
        const response = await fetch(`${laravel.URL}/alertes`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: usuari_id }),
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error("Error en fetchAlertes:", errorText);
            throw new Error(`Error al obtener las alertas: ${errorText}`);
        }

        return await response.json();
    } catch (error) {
        console.error("Error en fetchAlertes:", error);
        throw error;
    }
};

export const loginUser = async (loginData) => {
    try {
        const response = await fetch(`${laravel.URL}/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(loginData),
        });

        if (!response.ok) {
            const data = await response.json();
            throw new Error(data.message || 'Credenciales incorrectas');
        }

        return await response.json();
    } catch (error) {
        console.error("Error en loginUser:", error.message);
        throw error;
    }
};


// === ENVIAR ALERTA ===========
export async function enviarAlerta(data) {
    const url = `${laravel.URL}/alert`;
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error("Error al realizar la solicitud");
        }

        return await response.json();
    } catch (error) {
        console.error("Error en la solicitud:", error);
        throw error;
    }
}


export async function obtenerFotoPerfil(user_id, token){
    try {
        const response = await fetch(`${laravel.URL}/getPhoto/${user_id}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
            }
        });

        if(!response.ok){
            throw new Error(`Error al obtener la foto: ${response.statusText}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Error al obtener la foto de perfil:', error);
    }
}


export async function GetUserSectorAlertas(alumne_id) {
    try {
        const response = await fetch(`${laravel.URL}/getUser`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ alumne_id }),
        });

        if (!response.ok) {
            throw new Error('Error al obtener el usuario');
        }

        return await response.json();
    } catch (error) {
        console.error('Error en la solicitud de usuario:', error);
        throw error;
    }
}

export async function GetAlertasSectorAlertas(sector_id) {
    try {
        const response = await fetch(`${laravel.URL}/getAlertsSector`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                sector_id,
            }),
        });

        if (!response.ok) {
            throw new Error('Error al obtener las alertas del sector');
        }

        return await response.json();
    } catch (error) {
        console.error('Error en la solicitud de alertas:', error);
        throw error;
    }
}



// === HeatmapComp.vue ==================
export const HeatmapGetAllAlert = async () => {
    try {
        const response = await fetch(`${laravel.URL}/getAllAlerts`);
        if (!response.ok) {
            console.log("Error a la hora de obtener los datos");
        }
        return await response.json();
    } catch (error) {
        console.error("Error fetching alerts:", error);
        throw error;
    }
};


export async function AdminAlertes_getAllAlertsAdmin() {
    const response = await fetch(`${laravel.URL}/getAllAlertsAdmin`);
    if (!response.ok) {
        throw new Error(`Error fetching alerts: ${response.status}`);
    }
    return await response.json();
}

export async function AdminAlertes_updateAlert(id, estado) {
    const response = await fetch(`${laravel.URL}/updateAlert/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ estado }),
    });
    if (!response.ok) {
        throw new Error(`Error updating alert: ${response.status}`);
    }
    return await response.json();
}


export async function updateFoto( formData, token){
    try {
        const response = await fetch(`${laravel.URL}/updatePhoto`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
            },
            body: formData,
        });

        return await response.json();
    } catch (error) {
        console.error('Error al subir la imagen: ', error);
    }
}

export async function verificar_usuario_enquesta(id) {
    try {
        const response = await fetch(`${laravel.URL}/verificar-alumno/${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error(`Error en la solicitud: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error al verificar el usuario:', error);
        throw error;
    }
}
