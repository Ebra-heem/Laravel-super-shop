<template>
    <div class="container">
        
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customer Table</h3>

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
                    <th>Phone</th>
                    <th>Credit Limit</th>
                    <th>Address</th>                    
                    <th>Registered At</th>
                    <th>Action</th>
                  </tr>
                  <tr v-for="customer in customers" :key="customer.id">
                    <td>{{customer.id}}</td>
                    <td>{{customer.name}}</td>
                    <td>{{customer.phone}}</td>
                    <td>{{customer.credit_limit }}</td>
                    <td>{{customer.address }}</td>
                    <td>{{customer.created_at | myDate}}</td>
                    <td>
                        <a href="#" @click="editModal(customer)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click = "deleteUser(customer.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                        <a href="#" @click = "uploadPhoto(product.id)">
                            <i class="fa fa-eye green"></i>
                        </a>
                    </td>
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        
<!-- Add Product Modal-->

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
      <form @submit.prevent="editMode? updateModal():createCustomer()">
      <div class="modal-body">
        <div class="form-group">
      <input v-model="form.name" type="text" name="name"
        placeholder="Customer Name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
        </div>
        <div class="form-group">
      <input v-model="form.phone" type="text" name="phone"
        placeholder="Customer Phone Number"
        class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
      <has-error :form="form" field="phone"></has-error>
        </div>
        <div class="form-group">
      <input v-model="form.credit_limit" type="text" name="credit_limit"
        placeholder="Customer Credit Limit"
        class="form-control" :class="{ 'is-invalid': form.errors.has('credit_limit') }">
      <has-error :form="form" field="credit_limit"></has-error>
        </div>
        <div class="form-group">
      <textarea v-model="form.address" type="text" name="address"
        placeholder="Address"
        class="form-control" :class="{ 'is-invalid': form.errors.has('address') }"></textarea>
      <has-error :form="form" field="address"></has-error>
        </div>
        <div class="form-group">
      <select v-model="form.c_status" type="text" name="c_status"
        class="form-control" :class="{ 'is-invalid': form.errors.has('c_status') }">
        <option value=""> Select Status</option>
        <option value="1"> Active</option>
        <option value="0">Inactive</option>
        </select>
      <has-error :form="form" field="c_status"></has-error>
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

<div class="modal fade" id="addImg" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editMode? updateModal():createProduct()">
      <div class="modal-body">
        <div class="form-group">
          <div class="widget-user-image">
                <img class="img-circle" :src="getProductPhoto()" alt="User Avatar">
            </div>
            
              <div class="col-sm-12">
                <input type="file" @change="updateProfile" name="c_photo" class="form-input">
                 </div>

         </div>
        
        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button  type="submit" class="btn btn-success">Upload </button>
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
                customers : {},
                form: new Form({
                    id:'',
                    name: '',
                    phone: '',
                    credit_limit: '',
                    address: '',
                    c_photo: '',
                    c_status: ''
                })
            }
        },
        methods:{
          updateProfile(e){
               // console.log('uploading');
               //take the file from input fields
               let file = e.target.files[0];
              // console.log(file);
               let reader = new FileReader();
              //check file size is not max 2 MB
               if(file['size'] < 2111775){
                 reader.onloadend = (file)=>{
                  // console.log('Result',reader.result)
                  this.form.photo = reader.result;
               }
                  reader.readAsDataURL(file);
               }else{
                 Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    })
               }
               
        },
          uploadPhoto(){
            $('#addImg').modal('show');

          },
           getProductPhoto(){
             let photo = (this.form.c_photo.length >200)? this.form.c_photo :"img/profile/"+this.form.c_photo ;
             // return "img/profile/"+this.form.photo;
            // this.form.photo='';
             return photo;
           },
          updateModal(){
            //console.log("Update Data");
            this.$Progress.start();
            this.form.put('api/customer/'+this.form.id)
            .then( ()=>{

              this.$emit('AfterCreate');
                $('#addNew').modal('hide');
                
                Toast.fire({
                type: 'success',
                title: 'Customer Updated  successfully'
                })
                 this.$Progress.finish();

            })
            .catch(()=>{
              this.$Progress.fail();
            })
          },
          editModal(customer){
            this.editMode = true;
            this.form.reset();
             $('#addNew').modal('show');
             this.form.fill(customer);
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
                this.form.delete('api/customer/'+id).then( ()=>{
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


            loadCustomers(){
                axios.get("api/customer").then(({ data })=>(this.customers = data.data));
            },
            createCustomer(){

                 this.$Progress.start();
                this.form.post('api/customer')
                .then( ()=>{
                    this.$emit('AfterCreate');
                $('#addNew').modal('hide');
                
                Toast.fire({
                type: 'success',
                title: 'Customer Created in successfully'
                })
                 this.$Progress.finish();
                })
                .catch( ()=>{
                    console.log('error from customer component');
                })
                
            }
        },
        created() {
            this.loadCustomers();
           
            this.$on('AfterCreate',() => { 
                this.loadCustomers();
             });
              //setInterval( () => this.loadCustomers(),3000);
        }
    }
</script>
