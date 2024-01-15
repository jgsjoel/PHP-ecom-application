<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="resources/images/Logo.png">
    <link rel="stylesheet" href="resources/css/bootstrap.css">
    <link rel="stylesheet" href="resources/css/style.css">
</head>

<body>

    <button type="button" class="btn btn-primary" id="openChat">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="clientChatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: black;">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Chat With Us</h1>
                    <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: whitesmoke;height: 400px;overflow-y: auto;">
                    <div class="col-12">
                        <div class="row g-2" id="chatSection">
                            <!-- messages -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: black;">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-10">
                                <input type="text" class="form-control w-100" id="msgInput" placeholder="Type Your Message Here...">
                            </div>
                            <div class="col-2 text-center">
                                <button type="button" id="msgSend" class="btn btn-danger">Send <i class="bi bi-send-fill"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="javascript/bootstrap.min.js"></script>
    <script src="javascript/message.js"></script>
</body>

</html>