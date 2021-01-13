<template>
    <!-- file-pond -->
    <div class="form-group  ">
        <file-pond
            name="image"
            ref="pond"
            label-idle="Drop files here..."
            v-bind:allow-multiple="false"
            accepted-file-types="image/jpeg, image/png"
            allowImagePreview="true"
            imagePreviewHeight="200"
            imagePreviewWidth="300"
            imageResizeTargetWidth="300"
            imageResizeTargetHeight="200"
            filePosterMaxHeight="200"
            :server="{
                                               process: {
                                                      url: '/upload/card_bg',
                                                      method: 'POST',
                                                      headers: {
                                                     'X-CSRF-TOKEN': csrf
                                                                  }
                                                      }
                                                          }"
            :files="[ {
                                                        // the server file reference
                                                        // source: 'storage/app/public/card_bg/1_card_bg_121420202036345fd79b9a790f8.png',
                                                        source: address,

                                                        // set type to local to indicate an already uploaded file
                                                           options: {
                                                            type: 'local',
                                                             metadata: {

                                                                         // poster: '/storage/card_bg/1_card_bg_121420202036345fd79b9a790f8.jpg'
                                                                         poster: address
                                                                     }
                                                        }
                                                    }]"
            v-on:init="handleFilePondInit"
        />
    </div>
</template>

<script>
// import vueFilePond from 'vue-filepond';
import vueFilePond, {setOptions} from 'vue-filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
import FilePondPluginFileMetadata from 'filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.esm.js';
import FilePondPluginFileRename from 'filepond-plugin-file-rename';
// Import styles
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

// Import the plugin code
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';

// Import the plugin styles
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';


const FilePond = vueFilePond(FilePondPluginFileRename, FilePondPluginImagePreview, FilePondPluginFileMetadata, FilePondPluginFilePoster);


export default {
    props: {
        address: String,
        getInitData:{
            type: Function,
            default: () => {}
        }
    },
    components: {
        FilePond
    },
    data() {
        return {
            csrf: '',
            data: '',
        };
    },
    methods: {
        handleFilePondInit: function () {
            console.log('handleFilePondInit csrf. = ' + this.csrf)
            this.csrf = window.Laravel.csrfToken
        },
    },
    mounted() {
        console.log('cardDesigner mounted.')
        this.getInitData();
    },
    created: function () {
        console.log('cardDesigner created.')

        // this.data = this.$parent.data.data
        this.csrf = window.Laravel.csrfToken

        console.log('this.csrf =.')
        console.log(this.csrf)
    },
};
</script>
