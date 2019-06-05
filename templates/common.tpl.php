<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        <title>Простые числа в диапазоне</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<style type="text/css">
            body {
            	padding: 20px;
            }
        </style>
    </head>
    <body>
    	<div>
            <form class="needs-validation" novalidate>
            	<div class="form-row">
              		<div class="col-md-4 mb-3">
                		<label for="range_start">Начало диапазона</label>
                		<input type="text" class="form-control" id="range_start" required placeholder="Введите начало диапазона">
    					<small id="passwordHelpBlock" class="form-text text-muted">
      						Положительное число от 2 до <?php echo MAX_RANGE_NUMBER; ?>.
    					</small>
                		<div class="invalid-feedback">
          					Необходимо ввести целое положительное число от 2 до <?php echo MAX_RANGE_NUMBER; ?>.
        				</div>
              		</div>
              		<div class="col-md-4 mb-3">
                		<label for="range_end">Конец диапазона</label>
                		<input type="text" class="form-control" id="range_end" required placeholder="Введите конец диапазона">
    					<small id="passwordHelpBlock" class="form-text text-muted">
      						Положительное число от 2 до <?php echo MAX_RANGE_NUMBER; ?>.
    					</small>
                		<div class="invalid-feedback">
          					Необходимо ввести целое положительное число от 2 до <?php echo MAX_RANGE_NUMBER; ?>.
        				</div>
              		</div>
              	</div>
				<div class="form-row">
				</div>
				<div class="form-row">
					<button type="submit" class="btn btn-primary mb-2">Вычислить</button>
              	</div>
            </form>
    	</div>
    	<div id="result">  		
    	</div>
    </body>
    <script type="text/javascript">
    	$(function() {
        	$('form').submit(function() {
            	$('input, button').prop('disabled', true);
                $('input').removeClass('is-invalid');
            	$('#result').html('Идет вычисление...');
            	var form = this;
            	var data = {
                    'range_start': $('#range_start').val(),
                    'range_end': $('#range_end').val(),
                };
                $.ajax({
              	  type: 'POST',
            	  url: '/',
            	  data: data,
            	  dataType: 'json',                    
            	  success: function(result) {
                  	//console.log(result);
                    $('input, button').prop('disabled', false);
                  	if (result['error']) {
                      	// show errors
                  		$('#result').html('');
                  		for (var i in result['error']) {
                      		$('#' + i).addClass('is-invalid');
                  		}
                  	
                  	} else {
                  		$('#range_start').val(result['start']);
                  		$('#range_end').val(result['end']);
                  		var str = 'Получен результат (за ' + result['time'] + ' сек.):<br>'; 
                  		$('#result').html(str + result['numbers'].join(', '));
                  	}
                  }
                });
            	return false;
            });
    	});
    </script>
</html>