<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste</title>

    <link rel="stylesheet" href="public/css/app.css">

    <script src="public/js/app.js"></script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Questions form</div>
            <div class="card-body">
                <div id="lead-service-questions">
                    <lead-questions-form
                        :service-id="1">
                    </lead-questions-form>
                </div>  
            </div>
        </div>
    </div>

    <script src="public/js/leadQuestionsForm.js"></script>
</body>
</html>