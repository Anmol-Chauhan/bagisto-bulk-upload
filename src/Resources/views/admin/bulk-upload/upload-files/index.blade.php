<x-admin::layouts>

    <x-slot:title>
        @lang('bulkupload::app.admin.bulk-upload.upload-files.index')
    </x-slot>

    <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
        <!-- download samples -->
        <div class="import-product">
            <div class="flex justify-between items-center">
                <p class="text-[20px] text-gray-800 dark:text-white font-bold">@lang('bulkupload::app.admin.bulk-upload.upload-files.sample-file')</p>  
            </div><br>

            <x-admin::form
                :action="route('admin.bulk-upload.upload-file.download-sample-files')"
                method="post"
            >
                @csrf

                <x-admin::form.control-group class="w-full mb-[10px]">
                    <x-admin::form.control-group.label class="required">
                        @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="select"
                        name="download_sample"
                        id="download-sample"
                        rules="required"
                        :label="trans('bulkupload::app.admin.bulk-upload.run-profile.please-select')"
                    >
                        <option value="">
                            @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                        </option>
                        @foreach(config('product_types') as $key => $productType)
                            <option value="{{ $key }}-product-upload.csv">
                                @lang('bulkupload::app.admin.bulk-upload.upload-files.csv-file', ['filetype' => ucwords($key) ])
                            </option>

                            <option value="{{ $key }}-product-upload.xlsx">
                                @lang('bulkupload::app.admin.bulk-upload.upload-files.xls-file', ['filetype' => ucwords($key) ])
                            </option>
                        @endforeach
                    </x-admin::form.control-group.control>

                    <x-admin::form.control-group.error
                        class="mt-3"
                        control-name="download_sample"
                    >
                    </x-admin::form.control-group.error>
                </x-admin::form.control-group>
        
                <!-- Download Sample Product -->
                <div class="flex gap-x-[10px] items-center">
                    <button
                        type="submit"
                        class="primary-button"
                    >
                        @lang('bulkupload::app.admin.bulk-upload.upload-files.download')
                    </button>
                </div><br>
            </x-admin::form>
        </div>
        
        <!-- Import New products -->
        <div class="import-new-products">
            <div class="flex justify-between items-center">
                <p class="text-[20px] text-gray-800 dark:text-white font-bold">@lang('bulkupload::app.admin.bulk-upload.upload-files.import-products')</p>  
            </div><br>
            <x-admin::form
                method="POST"
                :action="route('admin.bulk-upload.upload-file.import-products-file')"
                enctype="multipart/form-data"
                @submit.prevent="onSubmit"
            >
                @csrf
        
                <?php $familyId = app('request')->input('family') ?>
        
                <div class="page-content">
                    <div class="is_downloadable">
                        <downloadable-input>
                            <div>
                                <x-admin::form.control-group class="w-full mb-[10px]">
                                    <x-admin::form.control-group.label>
                                        @lang('bulkupload::app.admin.bulk-upload.upload-files.is-downloadable')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="checkbox"
                                        name="is_downloadable"
                                        id="is_downloadable"
                                        @click="showOptions"
                                    >
                                    </x-admin::form.control-group.control>
                                </x-admin::form.control-group>

                                <x-admin::form.control-group class="w-full mb-[10px]" v-if="linkFiles">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('bulkupload::app.admin.bulk-upload.upload-files.upload-link-files')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="file"
                                        name="link_files"
                                        id="file"
                                        rules="required"
                                        :label="trans('bulkupload::app.admin.bulk-upload.upload-files.upload-link-files')"
                                        :placeholder="trans('bulkupload::app.admin.bulk-upload.upload-files.upload-link-files')"
                                    >
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error
                                        control-name="file_path"
                                    >
                                    </x-admin::form.control-group.error>
                                </x-admin::form.control-group>

                                <x-admin::form.control-group class="w-full mb-[10px]" v-if="isLinkSample">
                                    <x-admin::form.control-group.label>
                                        @lang('bulkupload::app.admin.bulk-upload.upload-files.sample-links')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="checkbox"
                                        name="is_link_have_sample"
                                        id="is_link_have_sample"
                                        @click="showlinkSamples"
                                        value="is_link_have_sample"
                                    >
                                    </x-admin::form.control-group.control>
                                </x-admin::form.control-group>

                                <x-admin::form.control-group class="w-full mb-[10px]" v-if="linkSampleFiles">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('bulkupload::app.admin.bulk-upload.upload-files.upload-link-sample-files')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="file"
                                        name="link_sample_files"
                                        id="file"
                                        rules="required"
                                        :label="trans('bulkupload::app.admin.bulk-upload.upload-files.upload-link-sample-files')"
                                        :placeholder="trans('bulkupload::app.admin.bulk-upload.upload-files.upload-link-sample-files')"
                                    >
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error
                                        control-name="file_path"
                                    >
                                    </x-admin::form.control-group.error>
                                </x-admin::form.control-group>

                                <x-admin::form.control-group class="w-full mb-[10px]" v-if="isSample">
                                    <x-admin::form.control-group.label>
                                        @lang('bulkupload::app.admin.bulk-upload.upload-files.sample-available')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="checkbox"
                                        name="is_sample"
                                        id="is_sample"
                                        @click="showSamples"
                                    >
                                    </x-admin::form.control-group.control>
                                </x-admin::form.control-group>

                                <x-admin::form.control-group class="w-full mb-[10px]" v-if="sampleFile">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('bulkupload::app.admin.bulk-upload.upload-files.upload-sample-files')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="file"
                                        name="sample_file"
                                        id="file"
                                        rules="required"
                                        :label="trans('bulkupload::app.admin.bulk-upload.upload-files.upload-sample-files')"
                                        :placeholder="trans('bulkupload::app.admin.bulk-upload.upload-files.upload-sample-files')"
                                    >
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error
                                        control-name="file_path"
                                    >
                                    </x-admin::form.control-group.error>
                                </x-admin::form.control-group>
                            </div>
                        </downloadable-input>
                    </div>
        
                    <div class="attribute-family">
                        <attribute-family>
                            <div>
                                <x-admin::form.control-group class="w-full mb-[10px]">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.family')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="select"
                                        name="attribute_family_id"
                                        id="attribute_family_id"
                                        rules="required"
                                        @change="onChange()"
                                        :label="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.family')"
                                    >
                                        <option value="">
                                            @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                                        </option>

                                        @foreach ($families as $family)
                                            <option value="{{ $family->id }}">
                                                {{ $family->name }}
                                            </option>
                                        @endforeach
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error
                                        class="mt-3"
                                        control-name="attribute_family_id"
                                    >
                                    </x-admin::form.control-group.error>
                                </x-admin::form.control-group>
                                
                                <x-admin::form.control-group class="w-full mb-[10px]">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.index')
                                    </x-admin::form.control-group.label>
                    
                                    <x-admin::form.control-group.control
                                        type="select"
                                        name="bulk_product_importer_id"
                                        id="bulk_product_importer_id"                    
                                        :label="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.index')"
                                    >
                                        <option value="">
                                            @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                                        </option>
                                        <option v-for="dataflowprofile,index in dataFlowProfiles" :value="dataflowprofile.id">
                                            @{{ dataflowprofile.name }}
                                        </option>
                                    </x-admin::form.control-group.control>
                    
                                    <x-admin::form.control-group.error
                                        class="mt-3"
                                        control-name="bulk_product_importer_id"
                                    >
                                    </x-admin::form.control-group.error>
                                </x-admin::form.control-group>
                            </div>
                        </attribute-family>
                    </div>
        
                    <x-admin::form.control-group class="w-full mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('bulkupload::app.admin.bulk-upload.upload-files.file')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="file"
                            name="file_path"
                            id="file"
                            rules="required"
                            :label="trans('bulkupload::app.admin.bulk-upload.upload-files.file')"
                            :placeholder="trans('bulkupload::app.admin.bulk-upload.upload-files.file')"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="file_path"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
        
                    <x-admin::form.control-group class="w-full mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('bulkupload::app.admin.bulk-upload.upload-files.image')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="file"
                            name="image_path"
                            id="image"
                            rules="required"
                            :label="trans('bulkupload::app.admin.bulk-upload.upload-files.image')"
                            :placeholder="trans('bulkupload::app.admin.bulk-upload.upload-files.image')"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="image_path"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                </div>
                <!-- Modal Submission -->
                <div class="flex gap-x-[10px] items-center">
                    <button 
                        type="submit"
                        class="primary-button"
                    >
                        @lang('bulkupload::app.admin.bulk-upload.upload-files.save')
                    </button>
                </div>
            </x-admin::form>
        </div>
    </div>
    

    @pushOnce('scripts')
        <script type="text/x-template" id="downloadable-input-template">
            <slot></slot>
        </script>

        <script type="text/x-template" id="attribute-family-template"> 
            <slot></slot>
        </script>

        <script type="module"> 
            app.component('downloadable-input', {
                    template: '#downloadable-input-template',

                    data() {
                        return {
                            key: "",
                            dataFlowProfiles: [],
                            isLinkSample: false,
                            isSample: false,
                            linkFiles: false,
                            linkSampleFiles: false,
                            sampleFile: false,
                            ttribute_family_id:[],
                            bulk_product_importer_id:[],
                        }
                    },

                    methods:{
                        showOptions() {
                            this.isLinkSample = ! this.isLinkSample;
                            this.isSample = ! this.isSample;
                            this.linkFiles = ! this.linkFiles;

                            this.linkSampleFiles = false;
                            this.sampleFile = false;
                        },

                        showlinkSamples() {
                            this.linkSampleFiles = ! this.linkSampleFiles;
                        },

                        showSamples() {
                            this.sampleFile = ! this.sampleFile;
                        }
                    },
                    disable(n){
                        return this.disabled.includes('A'+n);
                    }
            });

            app.component('attribute-family', {
                    template: '#attribute-family-template',

                    data() {
                        return {
                            key: "",
                            attribute_family_id:[],
                            bulk_product_importer_id:[],
                            dataFlowProfiles: {},
                        }
                    },

                    methods:{
                        onChange: function() {
                            console.log('');
                            var uri = "{{ route('admin.bulk-upload.upload-file.get-all-profile') }}"

                            this.$http.get(uri, {
                                params: {
                                    'attribute_family_id': this.key,
                                }
                            })
                            .then((response) => {
                                console.log(response);
                                this.dataFlowProfiles = response.data.dataFlowProfiles;
                            })
                            .catch(error => {
                            });
                        }
                    }
            });
        </script>
    @endPushOnce

</x-admin::layouts>
