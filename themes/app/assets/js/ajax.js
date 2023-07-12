// SELECIONA OS FORMULÁRIOS DO PROJETO
const formsToSubmit = document.querySelectorAll("form");
   
// ADICIONA O EVENTO A CADA UM
if (formsToSubmit) {
    formsToSubmit.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            fetchFormSubmit(this)
        })
    })
}

/**
 * Função assincrona responsável por manipular requests e responses ajax do projeto
 * 
 * @param form 
 * @returns void
 */
async function fetchFormSubmit(form) {
    const load = document.querySelector(".ajax_load");
    const flashClass = "ajax_response";
    const flash = document.querySelector("." + flashClass);

    load.style.display = "flex";
    // ESPERA O ENVIO COM O RETORNO
    const callback = await fetch(
        form.getAttribute("action"), {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(new FormData(form))
        })

    // SE RETORNAR A PROMESSA FOR CUMPRIDA PEGA OS DADOS
    const response = await callback.json();

    if (response) {
        setLabelsAndOpenModalToSearchNISRequest(response);

        //MESSAGEM / DISPARO DE MENSAGEM
        if (response.alert) {
            displaysTheAlertAtTheTopOfTheForm(flash, response);
        }
        // AO FINAL DE TUDO O LOADER SAÍ
        load.style.display = "none";
    }
}

/**
 * Função responsável por abrir o model e setar os dados após a pesquisa pelo NIS
 * @param  response 
 */
function setLabelsAndOpenModalToSearchNISRequest(response) {
    if (response.citizenName) {
        document.querySelector('.app_modal_box').style.display = 'flex';;
        document.querySelector('.app_modal').style.display = 'flex';
        document.querySelector('.citizenName').value = response.citizenName;
        document.querySelector('.citizenNis').value = response.citizenNis;

    }
}

/**
 * Função responsável apresentar e limpar mensagens de alertas
 * @param  flash 
 * @param  response 
 */
function displaysTheAlertAtTheTopOfTheForm(flash, response) {
    if (flash.textContent) {
        flash.textContent = '';
    }

    flash.innerHTML = response.alert.message;
    flash.style.display = 'flex';
}
