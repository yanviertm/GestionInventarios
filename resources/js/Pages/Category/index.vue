    <template>
        <layout menuActive="3">
            <a-divider orientation="left">
                <h4 class="color--secondary">Mis categorias</h4>
            </a-divider>
            <div v-if="dataCategory.length === 0">
                <a-button type="primary" @click="formModal=true">
                    Crear categoría
                </a-button>
                <br>
                <Empty title="categorias"></Empty>
            </div>
            <div v-if="dataCategory.length !== 0">
                <a-button type="primary" @click="formModal=true">
                    Crear categoría
                </a-button>
            </div>
            <div>
                <a-modal v-model="formModal" title="Categoría" cancelText="Cancelar" @ok="registerUpdateCategory" @cancel="cleanModal">
                    <a-form-model
                        ref="ruleForm"
                        :model="modelCategory"
                        @submit="registerUpdateCategory"
                    >
                        <a-form-model-item label="Nombre del categoría" prop="name">
                            <a-input v-model="modelCategory.name" />
                        </a-form-model-item>
                        <a-form-model-item label="Descripción" prop="description">
                            <a-textarea v-model="modelCategory.description" />
                        </a-form-model-item>

                    </a-form-model>
                </a-modal>

                <div v-if="loadingOnSave">
                    <a-spin class="loading-spinner">
                        <a-icon slot="indicator" type="loading"  style="font-size: 24px;vertical-align:middle;" spin />
                    </a-spin>
                </div>
            </div>
            <a-divider />
            <br>
            <a-row type="flex" justify="center" align="top">
               <div v-for="item in dataCategory">
                    <a-col :xs="24" :lg="6">
                        <a-card hoverable style="width: 300px;margin:1rem;">
                                <template slot="actions" class="ant-card-actions">
                                    <a-popconfirm
                                    title="¿Seguro que desea eliminar?"
                                    ok-text="Si"
                                    cancel-text="No"
                                    @confirm="deleteCategory(item.id)"
                                    @cancel="cleanModal"
                                >
                                    <a-icon type="delete"/>
                                </a-popconfirm>
                                <a-icon type="edit" @click="setFormUpdate(item.id)"/>
                            </template>
                            <a-card-meta :title="item.name" :description="item.description">
                            </a-card-meta>
                        </a-card>
                    </a-col>
                </div>
            </a-row>
        </layout>
    </template>

    <script>
        import Layout from './../../Layouts/Layout';
        import Empty from "../../Layouts/Components/Empty";
        import ErrorForm from "../../Layouts/ErrorForm";
        import axios from 'axios';
        export default {
            name: "index",
            components: {Layout, Empty, ErrorForm},
            props: ['categories'],
            data:()=>({
                columns:[
                    {
                        title: 'Categoría',
                        dataIndex: 'name',
                        key: 'name',
                    },
                    {
                        title: 'Descripción',
                        key: 'description',
                        dataIndex: 'description',
                    },
                    {
                        title: 'Acciones',
                        key: 'action',
                        scopedSlots: { customRender: 'action' },
                    },
                ],
                alertValidation: false,
                csrfToken:'',
                dataCategory: [],
                fileList:[],
                listCategories:[],
                loadingOnSave:false,
                modalEdit:false,
                modelCategory:{
                    id_category:null,
                    name:'',
                    description:'',
                    enabled:true,
                },
                formModal: false,
                deleteModal: false,
                err: {
                    info: null,
                    status: null,
                },
            }),
            methods:{
                registerUpdateCategory() {
                    this.loadingOnSave = true;
                    let data = {
                        id_category: this.modelCategory.id_category,
                        name: this.modelCategory.name,
                        description: this.modelCategory.description,
                    };
                    let url = "/categorias/registrar";
                    let method = "post";
                    if (this.modelCategory.id_category != null) {
                        url = "/categorias/actualizar";
                        method = "put";
                        data.id = this.modelCategory.id_category;
                    }
                    axios({ method, url, data })
                        .then((res) => {
                            this.dataCategory = res.data.info;
                            this.loadingHide();
                            if(this.modelCategory.id_category!=null) {
                                this.openNotification('success', 'Actualización exitosa','');
                            }else{
                                this.openNotification('success', 'Registro exitoso','')
                            }
                            this.cleanModal();
                        })
                        .catch((error) => {
                            this.err.info = error.response.data.info;
                            this.loadingHide();
                        });
                },
                deleteCategory(id) {
                    this.loadingOnSave = true;
                    let data = {
                        id: this.modelCategory.id_category,
                    };
                    let url = "/categorias/eliminar/" + id;
                    let method = "delete";
                    axios({ method, url, data })
                        .then((res) => {
                            this.dataCategory = res.data.info;
                            this.loadingHide();
                            this.openNotification('success', 'Registro eliminado exitosamente','');
                            this.cleanModal();
                        })
                        .catch((error) => {
                            this.err.info = error.response.data.info;
                            this.modelCategory.id_category = null;
                            this.loadingHide();
                        });
                },
                loadingHide(){
                    setTimeout(()=>{
                        this.loadingOnSave = false;
                    }, 2000);
                },
                openNotification(type, message, description) {
                    this.$notification.open({
                        message: message,
                        type: type,
                        description:description,
                    });
                },
                setFormUpdate(id) {
                    let category = this.dataCategory.filter((item) => item.id == id)[0];
                    this.modelCategory.id_category = category.id;
                    this.modelCategory.name = category.name;
                    this.modelCategory.description = category.description;
                    this.modelCategory.enabled = true;
                    this.formModal = true;
                },
                cleanModal(){
                    this.modelCategory.id_category = null;
                    this.modelCategory.name = '';
                    this.modelCategory.description = '';
                    this.modelCategory.enabled = true;
                    this.formModal=false;
                    this.deleteModal=false;
                    this.err.info=null;
                    this.err.status=null;
                },
            },
            mounted(){
                this.dataCategory = this.categories;
            },
        }
    </script>

    <style scoped>

    </style>

