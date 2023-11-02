<html lang="en">

<head>
    <title>Laravel 9 Preview and Crop Image Before Upload using Jquery Ajax</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <meta name="token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container" style="display: flex; justify-content:center; align-items:center; height:100vh">
        {{-- <div class="card" style="margin-top:20px;">
            <div class="card-header">
                Laravel 9 Preview and Crop Image Before Upload using Jquery Ajax
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div id="upload-demo"></div>
                    </div>
                    <div class="col-md-4" style="padding:5%;">
                        <strong>Select image for crop:</strong>
                        <input type="file" id="images" name="image">
                        <button class="btn btn-primary btn-block image-upload" style="margin-top:2%">Upload
                            Image</button>
                    </div>
                    <div class="col-md-4">
                        <div id="show-crop-image"
                            style="background:#e2e2e2;width:400px;padding:60px 60px;height:400px;"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg mt-5" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop">
            CLICK MODAL
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Preview and Crop Image Before Upload</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="margin-top:20px;">
                            {{-- <div class="card-header">
                                Preview and Crop Image Before Upload
                            </div> --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <div id="upload-demo"></div>
                                    </div>
                                    <div class="col-md-4" style="padding:5%;">
                                        <strong>Select image for crop:</strong>
                                        <div class="my-3">
                                            <input class="form-control" type="file" id="images" name="image">
                                        </div>
                                        <button class="btn btn-primary btn-block image-upload"
                                            style="margin-top:2%">Upload
                                            Image</button>
                                    </div>
                                    <div class="col-md-4">
                                        {{-- <strong>Preview after upload completes:</strong> --}}
                                        <div id="show-crop-image"
                                            style="background:#a4a3a3;width:300px;padding:60px 60px;height:300px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            }
        });

        var resize = $('#upload-demo').croppie({
            enableExif: true,
            enableOrientation: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },

            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#images').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                resize.croppie('bind', {
                    url: e.target.result
                }).then(function() {
                    console.log('success bind image');
                });

            }
            reader.readAsDataURL(this.files[0]);
        });

        $('.image-upload').on('click', function(ev) {
            resize.croppie('result', {
                type: 'canvas',
                size: 'viewport'

            }).then(function(img) {
                $.ajax({
                    url: '{{ route('save') }}',
                    type: "POST",
                    data: {
                        "image": img
                    },
                    success: function(data) {
                        html = '<img src="' + img + '" />';
                        $("#show-crop-image").html(html);
                    }
                });
            });
        });
    </script>
</body>

</html>
