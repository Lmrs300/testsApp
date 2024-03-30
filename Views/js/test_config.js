function crear_preg_corta() {

    div_preg = "<li class='contenedor_preg contenedor_preg_corta' tipo_preg='pregunta corta' style='--animation_name_dur: aparecer 1s;'><div class='quitar_preg' title='Quitar pregunta'>X</div><input type='text' id='preg' name='preg' class='preg' placeholder='Coloque una pregunta' required><input type='text' id='resp' name='resp' class='resp' placeholder='Aquí va la respuesta del estudiante' disabled></li>"

    $("#preguntas").append(div_preg)

    add_quit_listeners()

}

function crear_par() {
    div_preg = "<li class='contenedor_preg contenedor_par' tipo_preg='pregunta parrafo' style='--animation_name_dur: aparecer 1s;'><div class='quitar_preg' title='Quitar pregunta'>X</div><input type='text' id='preg' name='preg' class='preg' placeholder='Coloque una pregunta' required> <textarea type='text' cols='3' rows='3' id='resp' name='resp' class='resp' placeholder='Aquí va la respuesta del estudiante' disabled></textarea></li>"

    $("#preguntas").append(div_preg)

    add_quit_listeners()
}

function crear_sel_mul() {
    div_preg = "<li class='contenedor_preg contenedor_par' tipo_preg='pregunta sel mul'  style='--animation_name_dur: aparecer 1s;'><div class='quitar_preg' title='Quitar pregunta'>X</div><input type='text' id='preg' name='preg' class='preg' placeholder='Coloque una pregunta' required><ul class='radios_lista'><li class='radio_contenedor_agreg'><input type='text' id='agreg_radio' name='agreg_radio' class='agreg_radio' placeholder='+ Respuesta'></li></ul><div class='nota_sel'>Nota: Deje seleccionada la opción correcta</div></li>"

    $("#preguntas").append(div_preg)




    $(".agreg_radio").on("blur", (e) => {
        add_resp_radio(e)
    })

    //Para que se active cuando se presione la tecla ENTER.
    $(".agreg_radio").on("keydown", (e) => {
        if (e.which === 13) {
            add_resp_radio(e)
        }
    })

    add_quit_listeners()
}

function add_resp_radio(e) {
    let valorInput = e.currentTarget.value

    if (valorInput == "" || valorInput == " ") {
        e.currentTarget.value = ""
        return
    }

    let liRadio = document.createElement("li")

    liRadio.classList.add("radio_contenedor")

    let spanRadio = document.createElement("span")

    spanRadio.textContent = valorInput

    liRadio.append(spanRadio)

    let inputRadio = document.createElement("input")

    inputRadio.setAttribute("type", "radio")

    let random = Math.random() * 10000000

    inputRadio.setAttribute("id", random)

    let pregs = document.querySelectorAll(".contenedor_preg")

    inputRadio.setAttribute("name", "resp_radio" + pregs.length)

    inputRadio.classList.add("resp_radio")

    inputRadio.value = valorInput

    liRadio.append(inputRadio)

    let label = document.createElement("label")

    label.setAttribute("for", random)

    liRadio.append(label)

    let eliminar_radio = document.createElement("div")

    eliminar_radio.classList.add("eliminar_radio")

    eliminar_radio.textContent = "X"

    liRadio.append(eliminar_radio)


    e.currentTarget.parentElement.insertAdjacentElement("beforebegin", liRadio)

    e.currentTarget.value = ""

    $(".eliminar_radio").on("click", (e) => {
        e.currentTarget.parentElement.remove()
    })
}

function add_quit_listeners() {
    let Xs = document.querySelectorAll(".contenedor_preg .quitar_preg")

    Xs.forEach((x) => {
        x.addEventListener("click", quitar_preg)
    })
}

function quitar_preg(e) {
    //e.target.parentElement.style.setProperty("--animation_name_dur", "desaparecer 0.4s")
    e.target.parentElement.remove()
}