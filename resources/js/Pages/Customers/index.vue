<template>
    <layout menuActive="6">
        <a-divider orientation="left">
            <h4 class="color--secondary">Mis Clientes</h4>
        </a-divider>
        <div v-if="dataCustomer.length === 0">
            <a-button type="primary" @click="formModal=true">
                Crear cliente
            </a-button>
            <br>
            <Empty title="clientes"></Empty>
        </div>
        <div v-if="dataCustomer.length !== 0">
            <a-button type="primary" @click="formModal=true">
                Crear cliente
            </a-button>

            <a-row type="flex" justify="center" align="top">
                <a-table :columns="columns" :data-source="dataCustomer">
                    <span slot="name" slot-scope="name">{{ name }}</span>
                    <span slot="lastname" slot-scope="lastname">{{lastname}}</span>
                    <span slot="username" slot-scope="username">{{ username }}</span>
                    <span slot="email" slot-scope="email">{{email}}</span>
                    <span slot="action" slot-scope="text, record">
                        <a-popconfirm
                            title="¿Seguro que desea eliminar?"
                            ok-text="Si"
                            cancel-text="No"
                            @confirm="deleteCustomer(item.id)"
                            @cancel="cleanModal">
                            <a-icon type="delete"/>
                        </a-popconfirm>
                    <a-divider type="vertical" />
                    <a-icon type="edit" @click="setFormUpdate(record.id)"/>
                    <a-divider type="vertical" />
                    <a-icon type="profile" @click="openModalDetails(record.id)"/>
                    <a-modal v-model="deleteModal" title="Confirmación" cancelText="Cancelar" @ok="deleteCustomer(record.id)" @cancel="cleanModal">
                        <a-icon type="info-circle" theme="twoTone" two-tone-color="#eb2f96" class="danger"/>&nbsp;&nbsp; Desea eliminar al usuario {{record.name +' '+record.lastname}}?
                    </a-modal>
                </span>
                </a-table>
            </a-row>
        </div>
        <div>
            <a-modal v-model="formModal" title="Categoría" cancelText="Cancelar" @ok="registerUpdateCustomer" @cancel="cleanModal">
                <a-form-model
                    ref="ruleForm"
                    :model="modelCustomer"
                    @submit="registerUpdateCustomer"
                >
                    <a-form-model-item label="Nombre">
                        <a-input v-model="modelCustomer.name" />
                    </a-form-model-item>
                    <a-form-model-item label="Apellido">
                        <a-input v-model="modelCustomer.lastname" />
                    </a-form-model-item>
                    <a-form-model-item label="Tipo de identificación">
                        <a-select v-model="modelCustomer.document_type"
                                  show-search
                                  placeholder="Seleccione...."
                                  option-filter-prop="children"
                                  style="width: 200px">
                        <a-select-option
                            v-for="item in pre_type"
                            :value="item"
                            :key="item.index"
                        >
                            {{item}}
                        </a-select-option>
                    </a-select>
                    </a-form-model-item>
                    <a-form-model-item label="# de identificación">
                        <a-input v-model="modelCustomer.id_document" />
                    </a-form-model-item>
                    <a-form-model-item label="Email">
                        <a-input v-model="modelCustomer.email" />
                    </a-form-model-item>
                    <a-form-model-item label="Teléfono">
                        <a-input v-model="modelCustomer.phone" />
                    </a-form-model-item>
                    <a-form-model-item label="Pais">
                        <a-input v-model="modelCustomer.country" />
                    </a-form-model-item>
                    <a-form-model-item label="Ciudad">
                        <a-input v-model="modelCustomer.city" />
                    </a-form-model-item>
                    <a-form-model-item label="Dirección">
                        <a-input v-model="modelCustomer.address" />
                    </a-form-model-item>
                    <a-form-model-item label="Nombre de usuario">
                        <a-input v-model="modelCustomer.username" />
                    </a-form-model-item>
                    <a-form-model-item label="Contraseña">
                        <a-input-password v-model="modelCustomer.password" />
                    </a-form-model-item>
                </a-form-model>
                {{modelCustomer}}
            </a-modal>
            <a-modal v-model="detailModal" :title="'Usuario: '+modelCustomer.username" cancelText="Cerrar" :ok-button-props="{ props: { disabled: true } }" @cancel="cleanModal">
                <a-list item-layout="horizontal">
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.document_type"
                        >
                            <a slot="title">Tipo de document</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.id_document"
                        >
                            <a slot="title">Número de documento</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.name+' '+modelCustomer.lastname"
                        >
                            <a slot="title">Nombre completo</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.email"
                        >
                            <a slot="title">Email</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.phone"
                        >
                            <a slot="title">Teléfono</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.country"
                        >
                            <a slot="title">Pais</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.city"
                        >
                            <a slot="title">Ciudad</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.address"
                        >
                            <a slot="title">Dirección</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelCustomer.username"
                        >
                            <a slot="title">Nombre de usuario</a>
                        </a-list-item-meta>
                    </a-list-item>
                </a-list>
            </a-modal>

            <div v-if="loadingOnSave">
                <a-spin class="loading-spinner">
                    <a-icon slot="indicator" type="loading"  style="font-size: 24px;vertical-align:middle;" spin />
                </a-spin>
            </div>
        </div>
        <a-divider />
        <br>
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
    props: ['customers'],
    data:()=>({
        columns:[
            {
                title: 'Nombre',
                dataIndex: 'name',
                key: 'name',
            },
            {
                title: 'Apellidos',
                key: 'lastname',
                dataIndex: 'lastname',
            },
            {
                title: 'Nombre de Usuario',
                key: 'username',
                dataIndex: 'username',
            },
            {
                title: 'Email',
                key: 'email',
                dataIndex: 'email',
            },
            {
                title: 'Acciones',
                key: 'action',
                scopedSlots: { customRender: 'action' },
            },
        ],
        pre_type: ['CC','Pasaporte','Cedula de Extranjeria'],
        alertValidation: false,
        csrfToken:'',
        dataCustomer: [],
        fileList:[],
        loadingOnSave:false,
        modalEdit:false,
        modelCustomer:{
            id_customer:null,
            name:'',
            lastname:'',
            document_type:'',
            id_document:'',
            email:'',
            phone:'',
            country:'',
            city:'',
            address:'',
            username:'',
            password:'',
            enabled:true,
        },
        formModal: false,
        deleteModal: false,
        detailModal: false,
        err: {
            info: null,
            status: null,
        },
    }),
    methods:{
        registerUpdateCustomer() {
            this.loadingOnSave = true;
            let data = {
                id_customer: this.modelCustomer.id_customer,
                name: this.modelCustomer.name,
                lastname: this.modelCustomer.lastname,
                document_type: this.modelCustomer.document_type,
                id_document: this.modelCustomer.id_document,
                email: this.modelCustomer.email,
                phone: this.modelCustomer.phone,
                country: this.modelCustomer.country,
                city: this.modelCustomer.city,
                address: this.modelCustomer.address,
                username: this.modelCustomer.username,
                password: this.modelCustomer.password,
            };
            let url = "/clientes/registrar";
            let method = "post";
            if (this.modelCustomer.id_customer != null) {
                url = "/clientes/actualizar";
                method = "put";
                data.id = this.modelCustomer.id_customer;
            }
            axios({ method, url, data })
                .then((res) => {
                    this.dataCustomer = res.data.info;
                    this.loadingHide();
                    if(this.modelCustomer.id_customer!=null) {
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
        deleteCustomer(id) {
            this.loadingOnSave = true;
            let data = {
                id: this.modelCustomer.id_customer,
            };
            let url = "/clientes/eliminar/" + id;
            let method = "delete";
            axios({ method, url, data })
                .then((res) => {
                    this.dataCustomer = res.data.info;
                    this.loadingHide();
                    this.openNotification('success', 'Registro eliminado exitosamente','');
                    this.cleanModal();
                })
                .catch((error) => {
                    this.err.info = error.response.data.info;
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
            let customer = this.dataCustomer.filter((item) => item.id == id)[0];
            this.modelCustomer.id_customer = customer.id;
            this.modelCustomer.name = customer.name;
            this.modelCustomer.lastname = customer.lastname;
            this.modelCustomer.document_type = customer.document_type;
            this.modelCustomer.id_document = customer.id_document;
            this.modelCustomer.email = customer.email;
            this.modelCustomer.phone = customer.phone;
            this.modelCustomer.country = customer.country;
            this.modelCustomer.city = customer.city;
            this.modelCustomer.address = customer.address;
            this.modelCustomer.username = customer.username;
            this.modelCustomer.password = customer.password;
            this.formModal = true;
        },
        cleanModal(){
            this.modelCustomer.id_customer = null;
            this.modelCustomer.name = '';
            this.modelCustomer.lastname = '';
            this.modelCustomer.document_type = '';
            this.modelCustomer.id_document = '';
            this.modelCustomer.email = '';
            this.modelCustomer.phone = '';
            this.modelCustomer.country = '';
            this.modelCustomer.city = '';
            this.modelCustomer.address = '';
            this.modelCustomer.username = '';
            this.modelCustomer.password = '';
            this.formModal=false;
            this.deleteModal=false;
            this.err.info=null;
            this.err.status=null;
        },
        openModalDetails(id){
            let customer = this.dataCustomer.filter((item) => item.id == id)[0];
            this.modelCustomer.id_customer = id;
            this.modelCustomer.name = customer.name;
            this.modelCustomer.lastname = customer.lastname;
            this.modelCustomer.document_type = customer.document_type;
            this.modelCustomer.id_document = customer.id_document;
            this.modelCustomer.email = customer.email;
            this.modelCustomer.phone = customer.phone;
            this.modelCustomer.country = customer.country;
            this.modelCustomer.city = customer.city;
            this.modelCustomer.address = customer.address;
            this.modelCustomer.username = customer.username;
            this.modelCustomer.password = customer.password;
            this.detailModal = true;
        },
    },
    mounted(){
        this.dataCustomer = this.customers;
    },
}
</script>

<style scoped>

</style>

