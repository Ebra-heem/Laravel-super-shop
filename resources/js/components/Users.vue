<template>
    <div class="container">
        
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                 <button class="btn btn-success"  @click="newModal">  Add New <i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Registered At</th>
                    <th>Action</th>
                  </tr>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type | upText}}</td>
                    <td>{{user.created_at | myDate}}</td>
                    <td>
                        <a href="#" @click="editModal(user)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click = "deleteUser(user.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                    </td>
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        
<!-- Add User Modal-->

<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editMode" id="exampleModalLabel">Add New</h5>
        <h5 class="modal-title" v-show="editMode" id="exampleModalLabel" >Update   {{form.name}}'s Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editMode? updateModal():createUser()">
      <div class="modal-body">
        <div class="form-group">
      <input v-model="form.name" type="text" name="name"
        placeholder="Name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
        </div>
        <div class="form-group">
      <input v-model="form.email" type="text" name="email"
        placeholder="Email"
        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
      <has-error :form="form" field="email"></has-error>
        </div>

        <div class="form-group">
      <textarea v-model="form.bio" type="text" name="bio"
        placeholder="Short bio for user(Optional)"
        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
      <has-error :form="form" field="bio"></has-error>
        </div>
        <div class="form-group">
      <select v-model="form.type" type="text" name="type"
        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
        <option value=""> Select User Role</option>
        <option value="admin"> Admin</option>
        <option value="user"> Standard User</option>
        <option value="author"> Author</option>
        </select>
      <has-error :form="form" field="type"></has-error>
        </div>
        <div class="form-group">
      <input v-model="form.password" type="password" name="password"
        placeholder="Password"
        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
      <has-error :form="form" field="password"></has-error>
        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button v-show="editMode" type="submit" class="btn btn-success">Update </button>
        <button v-show="!editMode" type="submit" class="btn btn-primary">Create </button>
      </div>

      </form>

    </div>
  </div>
</div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                editMode: false,
                users : {},
                form: new Form({
                    id:'',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods:{
          updateModal(){
            //console.log("Update Data");
            this.$Progress.start();
            this.form.put('api/user/'+this.form.id)
            .then( ()=>{

              this.$emit('AfterCreate');
                $('#addNew').modal('hide');
                
                Toast.fire({
                type: 'success',
                title: 'User Updated  successfully'
                })
                 this.$Progress.finish();

            })
            .catch(()=>{
              this.$Progress.fail();
            })
          },
          editModal(user){
            this.editMode = true;
            this.form.reset();
             $('#addNew').modal('show');
             this.form.fill(user);
          },
          newModal(){
             this.editMode = false;
            this.form.reset();
             $('#addNew').modal('show');
          },
            deleteUser(id){
              Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                //send request to server
                this.form.delete('api/user/'+id).then( ()=>{
                   this.$emit('AfterCreate');
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                
                }).catch(()=>{
                  console.log('error from delete');
                })
                }
               
              })
            },


            loadUsers(){
                axios.get("api/user").then(({ data })=>(this.users = data.data));
            },
            createUser(){

                 this.$Progress.start();
                this.form.post('api/user')
                .then( ()=>{
                    this.$emit('AfterCreate');
                $('#addNew').modal('hide');
                
                Toast.fire({
                type: 'success',
                title: 'User Created in successfully'
                })
                 this.$Progress.finish();
                })
                .catch( ()=>{
                    console.log('error from user component');
                })
                
            }
        },
        created() {
            this.loadUsers();
           
            this.$on('AfterCreate',() => { 
                this.loadUsers();
             });
              //setInterval( () => this.loadUsers(),3000);
        }
    }
</script>
