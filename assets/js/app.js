(function($) {
	$("body").on("click", "#refreshimg", function(){
		$("#captcha").val('');
		$.post("newsession.php");
		$("#captchaimage").load("image_req.php");
		return false;
	});

	$( ".btn-vota" ).click(function() {
	  var voto = $(this).attr('id');
	  var img = $(this).attr('data-img');
	  votar(voto, img);
	});

	$( ".btn-doble" ).click(function() {
	  var voto = $(this).attr('data-id');
	  var img = $(this).attr('data-img');
	  votar(voto, img);
	});

	function votar(voto, img){

	  $("#id-doble").val(voto);

	  $("#img-artista").attr("src","assets/img/"+img);


	  $.ajax({
	    url: "ajax/check_session.php"

	  })
	    .done(function( msg ) {
	    	//console.log(msg);
	      if(msg == '1'){
	      	$('#modal-voto').removeClass("modal-gracias");
	      	$("#formDatos").show();
	      	$("#caja-gracias").hide();
	      	$("#title-gracias").hide();
	      	$('#modal-voto').modal();
	      }else{
	      	//data-toggle="modal" data-target="#modal-voto"
	      	$('#modal-voto').addClass("modal-gracias");
	      	$("#formDatos").hide();
	      	$("#title-form").hide();
	      	$("#caja-gracias").show();
	      	$("#title-gracias").show();

	      	$.ajax({
	      	  method: "POST",
	      	  url: "ajax/votar.php",
	      	  data: { voto: voto }
	      	})
	      	  .done(function( data ) {
	      	  	if(data == 'ok'){
		      	  	$('#modal-voto').modal();
				}
	      	  });
	      }
	    });

}

	var v = $("#formDatos").validate({
			rules: {
				captcha: {
					required: true,
					remote: "process.php"
				}
			},
			messages: {
				captcha: "Se requiere un código correcto. haz click en refrescar imagen para generar uno nuevo"
			},
			submitHandler: function(form) {
				$(form).ajaxSubmit({
					beforeSubmit: function() {
						$(".loading").fadeIn();
					},
					 success:    function(data) {
					 	console.log(data);
					 	$(".loading").fadeOut();

				        if(data == 'ok'){
				        	$("#formDatos").hide();
				        	$('#modal-voto').addClass("modal-gracias");
					      	$("#title-form").hide();
					      	$("#caja-gracias").show();
					      	$("#title-gracias").show();
					      }else{
					      	//error
					      }
				    }
				});
			}
	});

	jQuery.validator.addMethod("rut", function(value, element) {
	  return this.optional(element) || $.Rut.validar(value);
	}, "Debe ser un rut válido.");

	$('.rut').Rut({validation: false});

		$("#reset").click(function() {
			v.resetForm();
		});



})(jQuery); // End of use strict
