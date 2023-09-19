<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>


    <div class="container">
        <div class="row appendtag">

            {{-- <div  class="col-2">
                    <div class="card text-center">
                        <div class="card-header">
                            Featured
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                </div>
                                <label for="">  &nbsp;&nbsp; view all</label>
                                </div>
                                <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                </div>
                                <label for="">  &nbsp;&nbsp; view</label>
                                </div>
                                <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                </div>
                                <label for="">  &nbsp;&nbsp; update</label>
                                </div>
                                <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                </div>
                                <label for="">  &nbsp;&nbsp; create</label>
                                </div>
                                <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                </div>
                                <label for="">  &nbsp;&nbsp; delete</label>
                                </div>

                        </div>

                        </div>
                </div>
            --}}




        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>
<script>
    var html = '<div  class="col-2">' +
        '<div class="card text-center">' +
        '<div class="card-header">   </div>' +
        '<div class="card-body">' +
        '<div class="input-group mb-3">' +
        '<div class="input-group-text">' +
        '<input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">' +
        '</div>' +
        '<label for="">  &nbsp;&nbsp; view all</label>' +
        ' </div>' +
        '<div class="input-group mb-3">' +
        ' <div class="input-group-text">' +
        ' <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">' +
        '    </div>' +
        ' <label for="">  &nbsp;&nbsp; view</label>' +
        ' </div>' +
        ' <div class="input-group mb-3">' +
        '  <div class="input-group-text">' +
        '   <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">' +
        '  </div>' +
        ' <label for="">  &nbsp;&nbsp; update</label>' +
        '</div>' +
        '<div class="input-group mb-3">' +
        ' <div class="input-group-text">' +
        '    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">' +
        '   </div>' +
        '  <label for="">  &nbsp;&nbsp; create</label>' +
        '  </div>' +
        '  <div class="input-group mb-3">' +
        '    <div class="input-group-text">' +
        '      <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">' +
        '    </div>' +
        '    <label for="">  &nbsp;&nbsp; delete</label>' +
        '   </div>' +

        '  </div>' +

        ' </div>' +
        '</div>';
    $.get('http://localhost:8000/api/module/all', function(d) {
        $.each(d.data, function(i, v) {
            var html = '<div  class="col-2">' +
                '<div class="card text-center">' +
                '<div class="card-header"> ' + v.name + '  </div>' +
                '<div class="card-body">' +
                '<div class="input-group mb-3">' +
                '<div class="input-group-text">' +
                '<input class="form-check-input mt-0 ' + v.name +
                'view_all" type="checkbox" value="" class="" aria-label="Checkbox for following text input">' +
                '</div>' +
                '<label for="">  &nbsp;&nbsp; view all</label>' +
                ' </div>' +
                '<div class="input-group mb-3">' +
                ' <div class="input-group-text">' +
                ' <input class="form-check-input mt-0 ' + v.name +
                'view" type="checkbox" value="" aria-label="Checkbox for following text input">' +
                '    </div>' +
                ' <label for="">  &nbsp;&nbsp; view</label>' +
                ' </div>' +
                ' <div class="input-group mb-3">' +
                '  <div class="input-group-text">' +
                '   <input class="form-check-input mt-0 ' + v.name +
                'update" type="checkbox" value="" aria-label="Checkbox for following text input">' +
                '  </div>' +
                ' <label for="">  &nbsp;&nbsp; update</label>' +
                '</div>' +
                '<div class="input-group mb-3">' +
                ' <div class="input-group-text">' +
                '    <input class="form-check-input mt-0 ' + v.name +
                'create" type="checkbox" value="" aria-label="Checkbox for following text input">' +
                '   </div>' +
                '  <label for="">  &nbsp;&nbsp; create</label>' +
                '  </div>' +
                '  <div class="input-group mb-3">' +
                '    <div class="input-group-text">' +
                '      <input class="form-check-input mt-0 ' + v.name +
                'delete" type="checkbox" value="" aria-label="Checkbox for following text input">' +
                '    </div>' +
                '    <label for="">  &nbsp;&nbsp; delete</label>' +
                '   </div>' +

                '  </div>' +

                ' </div>' +
                '</div>';
            $('.appendtag').append(html);
            console.log(v);
            $.each(v.permission, function(ip, vp) {
                if (vp.permission_name == v.name + ".view_all") {
                    $('.' + v.name + 'view_all').prop('checked', true);
                }
                if (vp.permission_name == v.name + ".view") {
                    $('.' + v.name + 'view').prop('checked', true);
                }
                if (vp.permission_name == v.name + ".update") {
                    $('.' + v.name + 'update').prop('checked', true);
                }
                if (vp.permission_name == v.name + ".create") {
                    $('.' + v.name + 'create').prop('checked', true);
                }
                if (vp.permission_name == v.name + ".delete") {
                    $('.' + v.name + 'delete').prop('checked', true);
                }
            })

        })
    })
</script>

</html>
