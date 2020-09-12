<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-9 m-auto">
                    <img :src="photoUser" v-if="!showPhoto" class="w-100">
                    <img :src="photo" alt="" v-if="showPhoto" class="w-100">
                    <div class="input-group my-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text btn btn-success" id="inputGroupFileAddon01">Guardar</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" v-on:change="previewFile">
                            <label class="custom-file-label" for="inputGroupFile01">Seleccionar foto</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['user'],
    data(){
        return{
            file: null,
            photo: '',
            showPhoto: false,
            photoUser: this.user.photo
        }
    },
    methods:{
        async previewFile(event){
            this.file = event.target.files[0]
            this.photo = URL.createObjectURL(this.file);
            this.showPhoto = true

            this.changeFile()

        },

        async changeFile(){
            const form_data = new FormData()
            form_data.append('avatar', this.file, this.file.name)

            await axios.post(`/users/edit-information/photo/${this.user.id}`, form_data).then(async (res) => {
                swal('Foto actualizada con exito', 'para poder visualizar los cambios recargue la pagina.', 'success')
            })
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
