<template>
<div class="container">
        <div class="navbar navbar-light mb-3">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#newUser">
                Registrar
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover w-100" id="table-users">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cedula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Parqueadero</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in customers" :key="index">
                        <th>{{ index+1 }}</th>
                        <td>{{ customer.cedula }}</td>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.last_name }}</td>
                        <td>{{ customer.cel }}</td>
                        <td>{{ customer.address }}</td>
                        <td><a :href="`Parking/edit-information/${customer.parking.id}`">{{ customer.parking.name }}</a></td>
                        <td><a :href="`/Customer/edit-information/${customer.id}`" class="d-block text-center text-primary"><i class="fas fa-user-edit"></i></a></td>
                        <td><a href="#" class="d-block text-center text-danger" v-on:click="deleteCustomer(customer)"><i class="fas fa-user-minus"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="newUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 20000">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form-customer :data="false"></form-customer>
                        <!-- <form-customer data="{{$customer}}"></form-customer> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import formCustomer from './formCustomer'
    export default {
        props: ['data'],
        components:{
            formCustomer,
        },
        data(){
            return {
                customers: JSON.parse(this.data)
            }
        },
        mounted(){
            this.getTableCustomers()
        },
        methods:{
            async getTableCustomers(){
                $("#table-users").DataTable({
                    "language":{
                        "url" : "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                    },
                    responsive: "true",
                })
            },
            async deleteCustomer(customer){
                // swal('Confirmar eliminación', '¿seguro que deseas eliminar a ' + user.personal_information.name +'?', 'warning')
                swal({
                    title: "Confirmar eliminación",
                    text: "Si eliminas a "+customer.name + " no podras recuperar su información",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.delete(customer)
                    }
                })
            },

            async delete(customer){
                await axios.post(`/Customer/edit-information/delete/${customer.id}`).then(res => {
                    this.customers = res.data.customers
                    swal('',res.data.customer.name + " se eliminó con exito", 'success')
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
