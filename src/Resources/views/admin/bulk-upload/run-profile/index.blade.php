<x-admin::layouts>

    <x-slot:title>
        @lang('bulkupload::app.admin.bulk-upload.run-profile.index')
    </x-slot>

    <!-- Heading -->
    <div class="flex flex-col gap-2 max-w-full max-md:w-full">
        <div class="grid">
            <v-profiler></v-profiler>
        </div>
    </div>

    @pushOnce('scripts')
        <script type="text/x-template" id="profiler-template">
            <run-profile-form
                :families="{{ json_encode($families) }}"
            >
            </run-profile-form>
        </script>

        <script type="text/x-template" id="run-profile-form-template">
            <div class="run-profile">
                <x-admin::accordion>
                    <x-slot:header>
                        <p class="p-2.5 text-gray-600 dark:text-gray-300 text-[16px] font-semibold">
                            @lang('bulkupload::app.admin.bulk-upload.run-profile.index')
                        </p>
                    </x-slot:header>

                    <!-- Run Profiler -->
                    <x-slot:content>
                        <x-admin::form>
                            <x-admin::form.control-group class="w-full mb-2.5">
                                <x-admin::form.control-group.label>
                                    @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.family')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="select"
                                    name="attribute_family_id"
                                    id="attribute_family_id"
                                    v-model="attribute_family_id"
                                    @change="getImporter"
                                    :label="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.family')"
                                >
                                    <option value="">
                                        @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                                    </option>

                                    <option v-for="family in families" :key="family.id" :value="family.id">
                                        @{{ family.name }}
                                    </option>
                                </x-admin::form.control-group.control>
                            </x-admin::form.control-group>

                            <x-admin::form.control-group class="w-full mb-2.5">
                                <x-admin::form.control-group.label>
                                    @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.index')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="select"
                                    name="bulk_product_importer_id"
                                    id="bulk_product_importer_id"
                                    v-model="bulk_product_importer_id"
                                    @change="setProductFiles"
                                    :label="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.family')"
                                >
                                    <option value="">
                                        @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                                    </option>

                                    <option v-for="importer in product_importer" :key="importer.id" :value="importer.id">
                                        @{{ importer.name }}
                                    </option>
                                </x-admin::form.control-group.control>
                            </x-admin::form.control-group>

                            <x-admin::form.control-group class="w-full mb-2.5">
                                <x-admin::form.control-group.label>
                                    @lang('bulkupload::app.admin.bulk-upload.run-profile.select-file')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="select"
                                    name="product_file"
                                    id="product_file"
                                    v-model="product_file_id"
                                    @change="setProductFiles"
                                    :label="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.family')"
                                >
                                    <option value="">
                                        @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                                    </option>

                                    <option v-for="file in product_file" :key="file.id" :value="file.id">
                                        @{{ file.file_name }}
                                        (@{{ formatDateTime(file.created_at) }})
                                    </option>
                                </x-admin::form.control-group.control>
                            </x-admin::form.control-group>

                            <div class="page-action" v-if="this.product_file_id != '' && this.product_file_id != 'Please Select'">
                                <div class="flex gap-x-2.5 items-center">
                                    <span type="submit" @click="runProfiler" :class="{ disabled: isDisabled }" :disabled="isDisabled" class="primary-button">
                                        @lang('bulkupload::app.admin.bulk-upload.run-profile.run')
                                    </span>

                                    <span type="submit" @click="deleteFile" class="primary-button">
                                        @lang('bulkupload::app.admin.bulk-upload.upload-file.delete')
                                    </span>
                                </div>
                            </div>
                        </x-admin::form>
                    </x-slot:content>
                </x-admin::accordion>
            </div>
        </script>

        <script type="module">
            app.component('v-profiler', {
                template:'#profiler-template',

                data() {
                    return {
                    }
                },
            })

            app.component('run-profile-form', {
                template:'#run-profile-form-template',

                props: ['families'],

                data() {
                    return {
                        product_file: [],
                        product_file_id: '',
                        product_importer: [],
                        attribute_family_id: null,
                        bulk_product_importer_id: null,
                        is_uploading: false,
                    }
                },

                computed: {
                    isDisabled() {
                        return this.product_file_id === '' || this.product_file_id === 'Please Select';
                    },
                },

                methods: {
                    async getImporter() {
                        if (this.attribute_family_id === '' || this.attribute_family_id === 'Please Select') {
                            return; // Exit early if attribute_family_id is empty or 'Please Select'
                        }

                        try {
                            const uri = "{{ route('admin.bulk-upload.upload-file.get-importar') }}";

                            const response = await this.$axios.get(uri, {
                                params: {
                                    'attribute_family_id': this.attribute_family_id,
                                }
                            });

                            this.product_importer = Object.values(response.data.dataFlowProfiles);
                        } catch (error) {
                            // Handle errors here if needed
                        }
                    },

                    setProductFiles() {
                        if (this.bulk_product_importer_id === '' || this.bulk_product_importer_id === 'Please Select') {

                            return; // Exit early if bulk_product_importer_id is empty or 'Please Select'
                        }

                        const selectedProfile = this.product_importer.find(obj => obj.id === this.bulk_product_importer_id);

                        if (selectedProfile) {
                            // If an item with the specified id is found, set this.product_file to its import_product property
                            this.product_file = selectedProfile.import_product;
                        }

                    },

                    async deleteFile() {
                        if (this.product_file_id === '' || this.product_file_id === 'Please Select') {

                            return; // Exit early if product_file_id is empty or 'Please Select'
                        }

                        let id = this.product_file_id;

                        this.product_file_id = '';

                        try {
                            const uri = "{{ route('admin.bulk-upload.upload-file.delete') }}";

                            const response = await this.$axios.post(uri, {
                                bulk_product_importer_id: this.bulk_product_importer_id,
                                product_file_id: id,
                            });

                            this.product_file = response.data.importer_product_file;
                        } catch (error) {
                            // Handle errors here if needed
                        }
                    },

                    formatDateTime(value) {
                        const dateTime = new Date(value);

                        return dateTime.toLocaleString(); // Adjust the format as needed
                    },

                    // Run profiler and execute bulk-products
                    runProfiler() {
                        const id = this.product_file_id

                        this.product_file_id = '';

                        const uri = "{{ route('admin.bulk-upload.upload-file.run-profile.read-csv') }}";

                        this.$axios.post(uri, {
                            product_file_id: id,
                            bulk_product_importer_id: this.bulk_product_importer_id
                        })

                        .then((result) => {
                        })
                        .catch((error) =>{
                        })
                        .finally(() => {
                        });
                    },
                }
            });
        </script>
    @endPushOnce
</x-admin::layouts>
