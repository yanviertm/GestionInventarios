<template>
    <layout menuActive="2">
        <a-divider orientation="left">
            <h4 class="color--secondary">Mis productos</h4>
        </a-divider>
        <div v-if="dataProduct.length === 0">
            <a-button type="primary" @click="formModal=true" v-if="listCategories.length > 0">
                Crear producto
            </a-button>
            <a-alert v-if="listCategories.length === 0" message="Debe haber al menos una categoria para crear un nuevo producto" banner />
            <br>
            <Empty title="productos"></Empty>
        </div>
        <div v-if="dataProduct.length !== 0">
            <a-button type="primary" @click="formModal=true" v-if="listCategories.length > 0">
                Crear producto
            </a-button>
            <a-alert v-if="listCategories.length === 0" message="Debe haber al menos una categoria para crear un nuevo producto" banner />
        </div>
        <div>
            <a-modal v-model="formModal" title="Producto" cancelText="Cancelar" @ok="registerUpdateProduct" @cancel="cleanModal">
                <a-form-model
                    ref="ruleForm"
                    :model="modelProduct"
                    @submit="registerUpdateProduct"
                >
                    <a-form-model-item label="Categoría" prop="id_category">
                        <a-select v-model="modelProduct.id_category"
                                    show-search
                                  placeholder="Seleccione...."
                                  option-filter-prop="children"
                                  style="width: 200px">
                            <a-select-option
                                v-for="item in listCategories"
                                :value="item.id"
                                :key="item.id"
                            >
                                {{item.name}}
                            </a-select-option>
                        </a-select>
                    </a-form-model-item>
                    <a-form-model-item label="Nombre del producto" prop="name">
                        <a-input v-model="modelProduct.name" />
                    </a-form-model-item>
                    <a-form-model-item label="Descripción" prop="description">
                        <a-textarea v-model="modelProduct.description" />
                    </a-form-model-item>
                    <a-form-model-item label="Precio" prop="price">
                        <a-input v-model="modelProduct.price" />
                    </a-form-model-item>
                    <a-form-model-item label="Stock" prop="Stock">
                        <a-input v-model="modelProduct.stock" />
                    </a-form-model-item>
                    <a-form-model-item label="Imagen del producto" prop="logo" v-show="modelProduct.id_product==null">
                        <a-upload :file-list="fileList" :before-upload="setImg">
                            <a-button> <a-icon type="upload" /> Seleccionar imagen </a-button>
                        </a-upload>
                    </a-form-model-item>
                    <a-form-model-item label="Descuento" prop="discount">
                        <a-select v-model="modelProduct.discount"
                                  show-search
                                  placeholder="Seleccione...."
                                  option-filter-prop="children"
                                  style="width: 200px">
                            <a-select-option
                                v-for="item in pre_desc"
                                :value="item"
                                :key="item.index"
                            >
                                {{item*100+'%'}}
                            </a-select-option>
                        </a-select>
                    </a-form-model-item>
                </a-form-model>
                <error-form :err="err"></error-form>
            </a-modal>

            <a-modal v-model="detailModal" :title="modelProduct.name" cancelText="Cerrar" :ok-button-props="{ props: { disabled: true } }" @cancel="cleanModal">
                <a-list item-layout="horizontal">
                    <a-list-item >
                        <a-list-item-meta>
                            <img
                                slot="title"
                                :src="url_image"
                            />
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta>
                            <a-tag color="#87d068" v-if="modelProduct.discount > 0">
                                {{modelProduct.discount*100+'%'}}
                            </a-tag>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="modelProduct.description"
                        >
                            <a slot="title">Descripción</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item >
                        <a-list-item-meta
                            :description="'$'+modelProduct.price"
                        >
                            <a slot="title">Precio</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item v-if="modelProduct.stock>0">
                        <a-list-item-meta
                            :description="'En stock '+modelProduct.stock+' restantes'"
                        >
                            <a slot="title">Estado</a>
                        </a-list-item-meta>
                    </a-list-item>
                    <a-list-item v-if="modelProduct.stock===0">
                        <a-list-item-meta
                            description="No Disponible"
                        >
                            <a slot="title">Estado</a>
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
        <a-row type="flex" justify="center" align="top">
            <div v-for="item in dataProduct">
                <a-col :xs="24" :lg="6">
                    <a-card hoverable style="width: 300px;margin:1rem;">
                        <a-tag color="#87d068" v-if="item.discount > 0">
                            {{item.discount*100+'%'}}
                        </a-tag>
                        <img
                            slot="cover"
                            :src="item.url_img"
                        />
                        <template slot="actions" class="ant-card-actions">
                            <a-popconfirm
                                title="¿Seguro que desea eliminar?"
                                ok-text="Si"
                                cancel-text="No"
                                @confirm="deleteProduct(item.id)"
                                @cancel="cleanModal"
                            >
                                <a-icon key="delete" type="delete"  />
                            </a-popconfirm>
                            <a-icon key="edit" type="edit" @click="setFormUpdate(item.id)"/>
                            <a-icon key="profile" type="profile" @click="openModalDetails(item.id)"/>
                        </template>
                        <a-card-meta :title="item.name" :description="'$'+item.price">
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
    props: ['products','categories'],
    data:()=>({
        alertValidation: false,
        csrfToken:'',
        dataProduct: [],
        fileList:[],
        listCategories:[],
        loadingOnSave:false,
        pre_desc:[0.5,0.4,0.3,0.2,0.1],
        modelProduct:{
            id_product:null,
            id_category:null,
            name:'',
            price:'',
            description:'',
            stock:'',
            discount:0,
            image:null,
            enabled:true,
        },
        url_image:'',
        formModal: false,
        detailModal:false,
        deleteModal:false,
        err: {
            info: null,
            status: null,
        },
    }),
    methods:{
        registerUpdateProduct() {
            this.loadingOnSave = true;
            let url = "/productos/registrar";
            let method = "post";
            let form = new FormData();
            form.append("id_category",this.modelProduct.id_category);
            form.append("name",this.modelProduct.name);
            form.append("price",this.modelProduct.price);
            form.append("description",this.modelProduct.description);
            form.append("discount",this.modelProduct.discount);
            form.append("stock",this.modelProduct.stock);
            form.append("image",this.modelProduct.image);

            const { fileList } = this;
            fileList.forEach(file => {
                form.append('file', file);
            });

            if (this.modelProduct.id_product != null) {
                url = "/productos/actualizar";
                method = "post";
                form.append("id",this.modelProduct.id_product);
            }
            axios({ method, url, data:form })
                .then((res) => {
                    if(res.data.success===true){
                        this.dataProduct = res.data.info;
                        this.loadingHide();
                        if(this.modelProduct.id_product!=null) {
                            this.openNotification('success', 'Actualización exitosa','');
                        }else{
                            this.openNotification('success', 'Registro exitoso','')
                        }
                        this.cleanModal();
                    }
                })
                .catch((error) => {
                    this.err.info = error.response.data.info;
                    this.modelProduct.id_product = null;
                    this.loadingHide();
                });
        },
        deleteProduct(id) {
            let data = {
                id_product: id
            };
            let url = "/productos/eliminar/" + id;
            let method = "delete";
            axios({ method, url, data })
                .then((res) => {
                    this.dataProduct = res.data.info;
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
        setImg(file) {
            this.modelProduct.image    = [...this.fileList, file]
            this.fileList               = [...this.fileList, file];
            return false;
        },
        setFormUpdate(id) {
            let product = this.dataProduct.filter((item) => item.id == id)[0];
            this.modelProduct.id_product = id;
            this.modelProduct.id_category = product.id_category;
            this.modelProduct.name = product.name;
            this.modelProduct.description = product.description;
            this.modelProduct.price = product.price;
            this.modelProduct.stock = product.stock;
            this.modelProduct.discount = product.discount;
            this.modelProduct.enabled = product.enabled;
            this.formModal = true;
        },
        openModalDetails(id){
            let product = this.dataProduct.filter((item) => item.id == id)[0];
            this.modelProduct.id_product = id;
            this.modelProduct.name = product.name;
            this.modelProduct.description = product.description;
            this.modelProduct.discount = product.discount;
            this.modelProduct.price = product.price;
            this.modelProduct.stock = product.stock;
            this.url_image = product.url_img;
            this.detailModal = true;
        },
        openModalDelete(id){
            let product = this.dataProduct.filter((item) => item.id == id)[0];
            this.modelProduct.id_product = id;
            this.deleteModal = true;
        },
        cleanModal(){
            this.modelProduct.id_product = null;
            this.modelProduct.id_category = null;
            this.modelProduct.name = '';
            this.modelProduct.price = '';
            this.modelProduct.description = '';
            this.modelProduct.stock = '';
            this.modelProduct.discount = 0;
            this.modelProduct.image = null;
            this.modelProduct.enabled = true;
            this.formModal = false;
            this.detailModal = false;
            this.deleteModal = false;
            this.err.info=null;
            this.err.status=null;
            this.fileList = []
        },
    },
    mounted(){
        this.dataProduct = this.products;
        this.listCategories = this.categories;
    },
}
</script>

<style scoped>

</style>
