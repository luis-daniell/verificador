 console.log('funcionando');

var formulario = document.getElementById('formulario');
var respuesta = document.getElementById('respuesta');


//detecta el evento el click del id submit
formulario.addEventListener('submit', function(e){
        //evita que se ejecuta lo que esta por defecto del navegador
        //o sea que pase el usuario y pass por la url
    e.preventDefault();
    console.log('me diste un click')

        //obtiene lo que se escribio en el formulario
    var datos = new FormData(formulario);

    console.log(datos)
    console.log(datos.get('usuario'))
    console.log(datos.get('pass'))

    // fetch('post.php',{
    // fetch('post.php',{
    fetch('http://sitet.credicapital.com.mx:8085/CKapital.ApiServTest/oauth/token',{
        method: 'POST',
        body: datos
    })
        .then( res => res.json())
        .then( data => {
            console.log(data)
            if(data === 'error'){
                respuesta.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    Llena todos los campos
                </div>
                `
            }else{
                respuesta.innerHTML = `
                <div class="alert alert-primary" role="alert">
                    ${data}
                </div>
                `
            }
        } )
})