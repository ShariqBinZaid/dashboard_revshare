@extends('layouts.main')
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    setTimeout(() => {
        $('#kt_app_footer').hide() 
    }, 500);

</script>
@section('content')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-display-middle">
    <h1 class="w3-jumbo w3-animate-top w3-center"><code style="color:red">Access Denied</code></h1>
    <hr class="w3-border-white w3-animate-left" style="margin:auto;width:50%">
    <h3 class="w3-center w3-animate-right">You don't have permission to view this Module.</h3>
    <h3 class="w3-center w3-animate-zoom">🚫🚫🚫🚫</h3>
    <!--<h6 class="w3-center w3-animate-zoom">error code:403 forbidden</h6>-->
    </div>
@endsection
