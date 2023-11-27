<x-admin::layouts>
    <x-slot:title>
        @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.index')
    </x-slot>
    
    <v-create-bulk-product></v-create-bulk-product>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-create-bulk-product-template">
            <div>
                <div class="flex justify-between items-center">
                    <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                        @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.add-profile')
                    </p>
            
                    <div class="flex gap-x-[10px] items-center">
                        <div class="flex gap-x-[10px] items-center">
                            <!-- Create a new Group -->
                            @if (bouncer()->hasPermission('admin.bulk-upload.bulk-product-importer.index'))
                                <button 
                                    type="button"
                                    class="primary-button"
                                    @click="id=0; $refs.groupUpdateOrCreateModal.open()"
                                >
                                    @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.add-profile')
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- DataGrid -->
                <x-admin::datagrid src="{{ route('admin.bulk-upload.bulk-product-importer.index') }}" ref="datagrid">
                    @php
                        $hasPermission = bouncer()->hasPermission('admin.bulk-upload.bulk-product-importer.edit') || bouncer()->hasPermission('admin.bulk-upload.bulk-product-importer.delete');
                    @endphp

                    <!-- DataGrid Header -->
                    <template #header="{ columns, records, sortPage, selectAllRecords, applied}">
                        <div class="row grid grid-cols-{{ $hasPermission ? '6' : '5' }} grid-rows-1 gap-[10px] items-center px-[16px] py-[10px] border-b-[1px] dark:border-gray-800 text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 font-semibold"
                            :style="'grid-template-columns: repeat({{ $hasPermission ? '6' : '5' }} , 1fr);'"  
                        >
                            <div
                                class="flex gap-[10px] cursor-pointer"
                                v-for="(columnGroup, index) in ['','profile_name', 'name', 'locale_code','created_at']"
                            >
                                @if ($hasPermission)
                                    <label
                                        class="flex gap-[4px] items-center w-max cursor-pointer select-none"
                                        for="mass_action_select_all_records"
                                        v-if="! index"
                                    >
                                        <input
                                            type="checkbox"
                                            name="mass_action_select_all_records"
                                            id="mass_action_select_all_records"
                                            class="hidden peer"
                                            :checked="['all', 'partial'].includes(applied.massActions.meta.mode)"
                                            @change="selectAllRecords"
                                        >

                                        <span
                                            class="icon-uncheckbox cursor-pointer rounded-[6px] text-[24px]"
                                            :class="[
                                                applied.massActions.meta.mode === 'all' ? 'peer-checked:icon-checked peer-checked:text-blue-600' : (
                                                    applied.massActions.meta.mode === 'partial' ? 'peer-checked:icon-checkbox-partial peer-checked:text-blue-600' : ''
                                                ),
                                            ]"
                                        >
                                        </span>
                                    </label>
                                @endif
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="[&>*]:after:content-['_/_']">
                                        <span
                                            class="after:content-['/'] last:after:content-['']"
                                            :class="{
                                                'text-gray-800 dark:text-white font-medium': applied.sort.column == columnGroup,
                                                'cursor-pointer hover:text-gray-800 dark:hover:text-white': columns.find(columnTemp => columnTemp.index === columnGroup)?.sortable,
                                            }"
                                            @click="
                                                columns.find(columnTemp => columnTemp.index === columnGroup)?.sortable ? sortPage(columns.find(columnTemp => columnTemp.index === columnGroup)): {}
                                            "
                                        >
                                            @{{ columns.find(columnTemp => columnTemp.index === columnGroup)?.label }}
                                        </span>
                                    </span>

                                    <!-- Filter Arrow Icon -->
                                    <i
                                        class="ltr:ml-[5px] rtl:mr-[5px] text-[16px] text-gray-800 dark:text-white align-text-bottom"
                                        :class="[applied.sort.order === 'asc' ? 'icon-down-stat': 'icon-up-stat']"
                                        v-if="columnGroup.includes(applied.sort.column)"
                                    ></i>
                                </p>
                            </div>
                            <!-- Actions -->
                            @if ($hasPermission)
                                <p class="flex gap-[10px] justify-end">
                                    @lang('admin::app.components.datagrid.table.actions')
                                </p>
                            @endif
                        </div>
                    </template>

                    <!-- DataGrid Body -->
                    <template #body="{ columns, records, performAction, setCurrentSelectionMode, applied}">
                        <div
                            v-for="record in records"
                            class="row grid gap-[10px] items-center px-[16px] py-[16px] border-b-[1px] dark:border-gray-800 text-gray-600 dark:text-gray-300 transition-all hover:bg-gray-50 dark:hover:bg-gray-950"
                            :style="'grid-template-columns: repeat(' + (record.actions.length ? 6 : 5) + ', 1fr);'"
                        >
                            
                            @if ($hasPermission)
                                <input
                                    type="checkbox"
                                    :name="`mass_action_select_record_${record.id}`"
                                    :id="`mass_action_select_record_${record.id}`"
                                    :value="record.id"
                                    class="hidden peer"
                                    v-model="applied.massActions.indices"
                                    @change="setCurrentSelectionMode"
                                >

                                <label
                                    class="icon-uncheckbox rounded-[6px] text-[24px] cursor-pointer peer-checked:icon-checked peer-checked:text-blue-600"
                                    :for="`mass_action_select_record_${record.id}`"
                                >
                                </label>
                            @endif
                            <!-- profile name -->
                            <p v-text="record.profile_name"></p>

                            <!-- attribute name -->
                            <p v-text="record.name"></p>

                            <!-- local code -->
                            <p v-text="record.locale_code"></p>
                            
                            <!-- created_at -->
                            <p v-text="record.created_at"></p>
                           
                            <!-- Actions -->
                            <div class="flex justify-end">
                                <a @click="id=1; editModal(record)">
                                    <span
                                        :class="record.actions.find(action => action.title === 'Edit')?.icon "
                                        class="cursor-pointer rounded-[6px] p-[6px] text-[24px] transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center icon-edit"
                                        :title="record.actions.find(action => action.title === 'Edit')?.title"
                                    >
                                    </span>
                                </a>

                                <a @click="performAction(record.actions.find(action => action.method === 'POST'))">
                                    <span
                                        :class="record.actions.find(action => action.method === 'POST')?.icon"
                                        class="icon-delete cursor-pointer rounded-[6px] p-[6px] text-[24px] transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                        :title="record.actions.find(action => action.method === 'POST')?.title"
                                    >
                                    </span>
                                </a>
                            </div>
                        </div>
                    </template>
                </x-admin::datagrid>

                {!! view_render_event('bagisto.admin.bulk-upload.bulk-product-importer.index.list.after') !!}

                <!-- Modal Form -->
                <x-admin::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                    ref="modalForm"
                >
                    <form
                        @submit="handleSubmit($event, updateOrCreate)"
                        ref="groupCreateForm"
                        >
                        <!-- Create Group Modal -->
                        <x-admin::modal ref="groupUpdateOrCreateModal">          
                            <x-slot:header>
                                <!-- Modal Header -->
                                <p class="text-[18px] text-gray-800 dark:text-white font-bold">
                                    <span v-if="id">
                                        @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.edit-profile')
                                    </span>
                                    <span v-else>
                                        @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.add-profile')
                                    </span>
                                </p>    
                            </x-slot:header>
            
                            <x-slot:content>
                                <!-- Modal Content -->
                                <div class="px-[16px] py-[10px] border-b-[1px] dark:border-gray-800">
                                    <x-admin::form.control-group class="w-full mb-[10px]">
                                        <x-admin::form.control-group.label class="required">
                                            @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.name')
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="hidden"
                                            name="id"
                                        >
                                        </x-admin::form.control-group.control>

                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="name"
                                            id="name"
                                            rules="required"
                                            :label="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.name')"
                                            :placeholder="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.name')"
                                        >
                                        </x-admin::form.control-group.control>

                                        <x-admin::form.control-group.error
                                            control-name="name"
                                        >
                                        </x-admin::form.control-group.error>
                                    </x-admin::form.control-group>

                                    <x-admin::form.control-group class="w-full mb-[10px]">
                                        <x-admin::form.control-group.label class="required">
                                            @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.family')
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="select"
                                            name="attribute_family_id"
                                            id="attribute_family_id"
                                            rules="required"
                                            :label="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.family')"
                                        >
                                            <option value="">
                                                @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                                            </option>
                                            @foreach ($families as $family)
                                                <option value="{{ $family->id }}">{{ $family->name }}</option>
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
                                            @lang('bulkupload::app.admin.bulk-upload.bulk-product-importer.locale')
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="select"
                                            name="locale_code"
                                            id="locale_code"
                                            rules="required"
                                            :label="trans('bulkupload::app.admin.bulk-upload.bulk-product-importer.locale')"
                                        >
                                            <option value="">
                                                @lang('bulkupload::app.admin.bulk-upload.run-profile.please-select')
                                            </option>
                                            @foreach (core()->getAllLocales() as $localeModel)
                                                <option value="{{ $localeModel->code }}">
                                                    {{ $localeModel->name }}
                                                </option>
                                            @endforeach
                                        </x-admin::form.control-group.control>

                                        <x-admin::form.control-group.error
                                            class="mt-3"
                                            control-name="locale_code"
                                        >
                                        </x-admin::form.control-group.error>
                                    </x-admin::form.control-group>
                                </div>
                            </x-slot:content>
            
                            <x-slot:footer>
                                <!-- Modal Submission -->
                                <div class="flex gap-x-[10px] items-center">
                                    <button 
                                        type="submit"
                                        class="primary-button"
                                    >
                                        @lang('bulkupload::app.admin.bulk-upload.upload-files.save')
                                    </button>
                                </div>
                            </x-slot:footer>
                        </x-admin::modal>
                    </form>
                </x-admin::form>
            </div>
        </script>


        <script type="module">
            app.component('v-create-bulk-product', {
                template: '#v-create-bulk-product-template',

                data() {
                    return {
                        id: 0,
                    }
                },

                methods: {
                    updateOrCreate(params, { resetForm, setErrors  }) {
                        let formData = new FormData(this.$refs.groupCreateForm);

                        if (params.id) {
                            formData.append('_method', 'put');
                        }

                        this.$axios.post(params.id ? "{{ route('admin.bulk-upload.bulk-product-importer.update') }}" : "{{ route('admin.bulk-upload.bulk-product-importer.add') }}", formData)
                            .then((response) => {
                                this.$refs.groupUpdateOrCreateModal.close();

                                this.$refs.datagrid.get();

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                resetForm();
                            })
                            .catch(error => {
                                if (error.response.status ==422) {
                                    setErrors(error.response.data.errors);
                                }
                            });
                    },

                    editModal(value) {
                        console.log(value);
                        this.$refs.groupUpdateOrCreateModal.toggle();

                        this.$refs.modalForm.setValues(value);
                    },
                }
            })
        </script>
    @endPushOnce

</x-admin::layouts>






        