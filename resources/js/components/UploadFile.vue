<template>
    <div>
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Dropzone</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">File Uploader</a>
                            </li>
                            <li class="breadcrumb-item active">Dropzone
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <section id="dropzone-examples">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Single File Upload</h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <b-form @submit="onSubmit" @reset="onReset">
                                        <b-form-file
                                            accept=".xml"
                                            v-model="form.file"
                                            :state="Boolean(form.file)"
                                            placeholder="Choose a file or drop it here..."
                                            drop-placeholder="Drop file here..."
                                        ></b-form-file>
                                        <div class="form-actions center">
                                            <b-button type="reset" variant="btn btn-warning mr-1">Сбросить</b-button>
                                            <b-button type="submit" variant="btn btn-primary">Загрузить</b-button>
                                        </div>

                                    </b-form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </div>
    </div>
</template>

<script>
export default {
    name:'UploadFile',
    data() {
        return {
            form: {
                file: null,
            },
        }
    },
    methods: {
        onSubmit(event) {
            event.preventDefault();
            let formData = new FormData();

            formData.append('file',this.form.file);

            toastr.info('Файл в обработке!', 'Оповещение!', {"progressBar": true});

            axios.post(this.$apiURI+"xml/upload",formData,{
                headers: {'Content-Type': 'multipart/form-data'},
                timeout: 240000
            }).then(response =>{
                let responseData = response.data;
                toastr.success(responseData.message, 'Оповещение!', {"progressBar": true});
                this.reset()
            }).catch(error => {
                if(!!error.response.data.errors){
                    $.each(error.response.data.errors, function(key, value) {
                        toastr.error(value[0], 'Оповещение!', {"progressBar": true});
                    });
                }
                if(error.response.status === 500){
                    toastr.error(error.response.data.message, 'Оповещение!', {"progressBar": true});
                }
            })
        },
        onReset(event) {
            event.preventDefault()
            this.reset()
        },
        reset(){
            this.form.file = null
        }

    }
}
</script>

<style scoped>

</style>
