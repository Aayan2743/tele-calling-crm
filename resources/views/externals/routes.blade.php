<script>
    const storeStaffUrl = "{{ route('user.store') }}";
    const updateStaffUrl = "{{ route('user.update') }}";
    const getusersUrl = "{{ route('users.index') }}";
    const userImageStorage = "{{ url('storage') }}";
    const defaultImage = "{{ url('storage/default.jpg') }}";
    const deleteUsers = "{{ route('deleteUsers') }}";
    const user_list = "{{ route('user.list') }}";
    const add_phone_number = "{{ route('add.phone.number') }}";
    const bulk_upload = "{{ route('bulk_upload') }}";
    const bulk_auto_upload = "{{ route('bulk_auto_upload') }}";
    const users_stats = "{{ route('user_stats') }}";
    const add_lead = "{{ route('add_lead') }}";
    const show_leads = "{{ route('show_leads') }}";
    const update_lead = "{{ route('update_lead') }}";
    var viewRoute = "{{ route('viewlead', ['id' => '__id__']) }}";

 
   
    
</script>