<?php
session_start();
if(isset($_SESSION['supprok']))
{
    $message = $_SESSION['supprok'];
    unset($_SESSION['supprok']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title id="titre">THALES</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    </head>
    <body>
        <header>
            <p>TEST</p>
        </header>

        <nav>
            <a href='oui'>Accueil</a>
            <a href='oui'>Crédit</a>
            <a href='oui'>TEST</a>
            <a href='oui'>TEST</a>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="text-center font">Recherchez le fichier souhaité par son ID dans la base, par son nom ou par sa date</h4>
                            <h5><?php if(isset($message)){echo $message;} ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Recherche">
                                    </div>
                                    <div>
                                        <button id="refresh-button" class="btn btn-primary" type="button">Rafraîchir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <table id="result" class="table table-bordered">
                            <h4 class="text-center font">Affichage des fichiers par recherche</h4>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered">
                                <h4 class="text-center font">Affichage des 5 derniers fichiers insérés dans la base de données</h4>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
        </footer>
    </body>
</html>
<script>
    $(document).ready(function(){
        $('#search').keyup(function(){
            var txt = $(this).val();
            if(txt != '')
            {
                $.ajax({
                    url:"fetchfic.php",
                    method:"post",
                    data:{search:txt},
                    dataType:"text",
                    success:function(data)
                    {
                        $('#result').html(data);
                    }
                });
            }
            else
            {
                $('#result').html('');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Function to refresh the data
        function refreshData() {
            $.ajax({
                url:'refresh.php', // Replace 'refresh.php' with the URL of your PHP file that contains the query
                type:'POST',
                success: function(response) {
                    $('#data-table').html(response); // Update the table content with the response from the server
                },
                error: function() {
                    alert('Error occurred while refreshing data.');
                }
            });
        }

        // Button click event
        $('#refresh-button').click(function() {
            refreshData();
        });

        // Initial data load
        refreshData();
    });
</script>
<script>
        $(document).on('click', '.confirm', function(e) {
            e.preventDefault(); // Prevent the default form submission
            var form = $(this).closest('form'); // Get the closest form element
            
            $.confirm({
                title: 'Attention !',
                content: 'Êtes-vous sûrs de vouloir supprimer ce fichier ?',
                buttons: {
                    Oui: function () {
                        form.trigger('submit'); // Submit the form if the user confirms
                    },
                    Annuler: function () {
                        // Do nothing if the user cancels
                    }
                }
            });
        });
</script>