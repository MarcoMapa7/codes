<!DOCTYPE html>
	<head>
		<title>Criando QrCode no PHP </title>
		   <meta charset="UTF-8"/>
	</head>

	<body>
		<h1>Criando QrCode no PHP</h1>
		
		<form>
			<fieldset>
				<input type="text" id="texto" placeholder="Texto" />
				<select id="nivel">
					<option value="L">Nivel redundancia L</option>
					<option value="M">Nivel redundancia M</option>
					<option value="Q">Nivel redundancia Q</option>
					<option value="H">Nivel redundancia H</option>
				</select>
				<select id="pixels">
					<option value="4">quadradinho de 4px</option>
					<option value="8">quadradinho de 8px</option>
					<option value="10">quadradinho de 10px</option>
					<option value="16">quadradinho de 16px</option>
				</select>
				<label>
					<input type="radio" name="img" value="J" />
					JPEG
				</label>
				<label>
					<input type="radio" name="img" value="P" checked="checked" />
					PNG
				</label>
				<br />
				<button type="button" id="botao">Gerar QR Code</button>
			</fieldset>
		</form>
		
		<?php
			$aux = 'qr_img0.50j/php/qr_img.php?';
			$aux .= 'd=Criando QrCode no PHP&';
			$aux .= 'e=H&';
			$aux .= 's=10&';
			$aux .= 't=J';
		?>
		<div style="float: left; border: 1px solid #000;">
			<img src="<?php echo $aux; ?>" />
		</div>
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script type="text/javascript">
			$('#botao').click(function(e){
				e.preventDefault();
				var texto = $('#texto').val();
				var nivel = $('#nivel').val();
				var pixels = $('#pixels').val();
				var tipo = $('input[name="img"]:checked').val();
				
				if(texto.length == 0){
					alert('Informe um texto');
					return(false);
				}
				//alert('qr_img0.50j/php/qr_img.php?d='+texto+'&e='+nivel+'&s='+pixels+'&t='+tipo);
				alert('QR Code Gerado!');
				$('img').attr('src', 'qr_img0.50j/php/qr_img.php?d='+texto+'&e='+nivel+'&s='+pixels+'&t='+tipo);
			});
		</script>
	</body>
</html>