<template>
    <div>
        <form  v-on:submit.prevent="store">
            <div class="form-group">
                <label for="password-old">Contraseña actual</label>
                <input type="password" class="form-control" id="password-old" v-model="password.old" required>
            </div>
            <div class="form-group">
                <label for="password-new">Nueva contraseña</label>
                <input type="password" class="form-control" id="password-new" v-model="password.new" required>
            </div>
            <div class="form-group">
                <label for="password-confirm">Confirmar contraseña</label>
                <input type="password" class="form-control" id="password-confirm" v-model="password.confirm" required>
            </div>
            <div class="input-group d-flex justify-content-around align-items-center m-auto my-4" style="max-width: 500px">
                <input type="submit" value="Actualizar" class="btn btn-success">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props:['user'],
        data(){
            return{
                password: {
                    old : '',
                    new: '',
                    confirm: '',
                }
            }
        },

        methods:{
            async store(){
                await axios.post(`/users/edit-information/change-password/${this.user.id}`, this.password).then(res => {

                    swal(res.data.title, res.data.menssage, res.data.alert)
                    .then((value) => {
                        if(res.data.update){
                            swal( "Debes volver a inciar sesión.","", "warning")
                            .then((value) => {
                                window.location.href="/logout"
                            })
                        }else{
                            this.password.old = ''
                            this.password.new = ''
                            this.password.confirm = ''
                        }
                    })
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
