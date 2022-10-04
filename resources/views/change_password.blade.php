<html>
  <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <style>
        body {
        background-color: #D3E2EC;
        }
        .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        width:600px;
        margin:0 auto;
        border:1px solid #ccc;
        }
        input {
        width: 100%;
        border: 2px #2874A6;
        padding: 12px 20px;
        border-radius: 4px;
        }

        input[type=submit]:hover {
        background-color: #3498DB;
        }

        input[type=submit] {
        background-color: #2874A6;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
        }

    </style>
  </head>
  <body>
    <br/>
    <div class = "container">
    <form action = "{{ route('update_password') }}" method = "POST">
        @csrf

        @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        <div class="form-group">
                <label for="old_password">Current Password</label>
                <input type="password" class="form-control" name="old_password" required="required" autofocus>
                @if ($errors->any('old_password'))
                <span class="text-danger">{{ $errors->first('old_password') }}</span>
                @endif
        </div>
        <br/>
        <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" name="new_password" required="required">
                @if ($errors->any('new_password'))
                <span class="text-danger">{{ $errors->first('new_password') }}</span>
                @endif
        </div>
        <br/>
        <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" required="required">
                @if ($errors->any('confirm_password'))
                <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                @endif
                
        </div>
        <br/>
        
        <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
        </div>
        <br/><br/><br/>
        <a href="{{ url('/index') }}">Go back to Homepage</a>
    </form>
    </div>
  </body>
</html>