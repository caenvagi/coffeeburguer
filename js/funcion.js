$(document).ready(function () {
// agregando el active a los botones//
    $('.category_list .category_item[category="all"]').addClass("ct_item_active");

        $(".category_item").click(function () {
            var catProduct = $(this).attr("category");
            console.log(catProduct);

        $(".category_item").removeClass("ct_item_active");
        $(this).addClass("ct_item_active");
        $(".product_item").hide();

        $('.product_item[category="' + catProduct + '"]').show();
        $('.category_item[category="all"]').click(function () {
            $(".product_item").show();
        });
});





// document.getElementById("proditem").style.display = "none";

// document.getElementById("total1").style.display = "none";

// function mostrar() {    
// document.getElementById("proditem").style.display = "block";
// document.getElementById("total1").style.display = "block";
// };

// $('.product_item').click(function(){
//     var valProduct = $(this).attr('value');
//     var nomProduct = $(this).attr('product');
//     var preProduct = $(this).attr('precio');

//         console.log(valProduct);
//         document.getElementById("prod-nom1").innerHTML = nomProduct;
//         document.getElementById("prod-nom2").innerHTML = preProduct;
//});
// $('.product_item').click(function(){
//     var valProduct = $(this).attr('value');
//     var nomProduct = $(this).attr('product');
//     var preProduct = $(this).attr('precio');

//     const proditem = document.getElementById('proditem');
//         console.log(proditem);

//     const li = document.createElement('li');
//         li.textContent = nomProduct  +  preProduct ;

//     proditem.appendChild(li);
// });

$(function(){

    fetchtask();

    $('#task-form').submit(function(e){
        var producto = $('#detalle_producto').val();    
            console.log(producto) ; 
 
        const postData = {
            codigo_recibo_detalle: $('#codigo_recibo_detalle').val(),
            detalle_mesa: $('#detalle_mesa').val(),
            detalle_producto: $('#detalle_producto').val(),            
            detalle_cantidad: $('#detalle_cantidad').val(),
            detalle_precio: $('#detalle_precio').val(),
            detalle_estado: $('#detalle_estado').val(),            
        };
            console.log(postData);
            
        $.post('task-add.php', postData, function(response){

            console.log(postData);
            console.log(response);

            fetchtask();           
        });       
        e.preventDefault();
    });    

    function fetchtask(){
        var mesa = $('#detalle_mesa').val() ;
            console.log(mesa);
        $.ajax({
            url:'task-list.php',
            type:'POST',
            async:true,
            data: {mesa:mesa},
            success: function(response){
                console.log(response);
                let tasks = JSON.parse(response);
                let template = '';
                tasks.forEach(task => {
                    template += `
                    <tr>
                        
                        <td>${task.producto_nombre}</td>
                        <td>${task.totalcant}</td>
                        <td> $ ${task.totalprecio}</td>
                        <td><button type="button" href:"task-delete.php" class="btn btn-danger" onclick="location.href='task-delete.php?producto_id=${task.producto_id}&codigo_recibo_detalle=${task.codigo_recibo_detalle}&pedido_mesa=${task.pedido_mesa}'"><span class="material-symbols-outlined">
                        delete
                        </span></button></td>
                        
                    </tr>
                    `
                });
                $('#tasks').html(template);
            },
            error:function(error){
                console.log(error);
            }, 

                
            
    
        });
    }
});
});   
