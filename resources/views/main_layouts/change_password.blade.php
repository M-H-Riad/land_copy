   <div id="change-password-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
                <h4 class="modal-title" id="myModalLabel2">Change Password</h4>
            </div>
            <div class="modal-body">
                <form  action="{{ url('/change-password') }}"  method="post" >
                    {{ csrf_field() }}
                    <div class="form-group">

                        <div >
                            <input placeholder="Old Password" type="password"  name="old_password" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">

                        <div >
                            <input placeholder="New Password" type="password"  name="password" required="required" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">

                        <div >
                            <input placeholder="Confirm  New Password" type="password" name="password_confirmation" required="required" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>