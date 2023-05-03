<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';
import Checkbox from '@/Components/Checkbox.vue';


const numInput = ref(null);
const estadoInput = ref(null);
const salaInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    cama: { type: Object },
    sala: { type: Object }
});

const form = useForm({
    numero_cama: '',
    estado_cama: '',
    sala_id: '',
});

const formPage = useForm({});

const onPageClick = (event) => {
    formPage.get(route('camas.index', { page: event }));
}

const openModal = (op, numero_cama, estado_cama, cam, sal) => {
    modal.value = true;
    nextTick(() => numInput.value.focus());
    operation.value = op;
    id.value = cam;
    if (op == 1) {
        title.value = 'Crear Cama';
    }
    else {
        title.value = 'Editar Cama';
        form.numero_cama = numero_cama;
        form.estado_cama = estado_cama;
        form.sala_id = sal;
    }
}
const closeModal = () => {
    modal.value = false;
    form.reset();
}

const save = () => {
    if (operation.value == 1) {
        form.post(route('camas.store'), {
            onSuccess: () => { ok('Cama creada') }
        });
    }
    else {
        form.put(route('camas.update', id.value), {
            onSuccess: () => { ok('Cama modificada') }
        });
    }
}
const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: 'success' });
}

const deleteCama = (id, numero_cama) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: 'Estas sguro de eliminar ' + numero_cama + ' ?',
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, eliminar',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('camas.destroy', id)), {
                onSuccess: () => { ok('Cama eliminada') }
            }
        }
    })
}
</script>

<template>
    <Head title="Camas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Camas</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Add
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Num. Cama</th>
                            <th class="px-4 py-4">Estado</th>
                            <th class="px-4 py-4">Num. Sala</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cam, i in cama" :key="cam.id">
                            <td class="border border-gray-400 px-4 py-4">{{ (i + 1) }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ cam.numero_cama }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ cam.estado_cama }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ cam.sala }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <WarningButton @click="openModal(2, cam.numero_cama, cam.estado_cama, cam.sala_id, cam.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton @click="deleteCama(cam.id, cam.numero_cama)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <VueTailwindPagination :current="cama.currentPage" :total="cama.total" :per-page="cama.perPage"
                    @page-changed="onPageClick($event)"></VueTailwindPagination>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal()">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="numero_cama" value="Numero de cama: "></InputLabel>
                <TextInput id="numero_cama" ref="numInput" v-model="form.numero_cama" type="number" class="mt-1 block w-3/4"
                    placeholder="ingrese el numero de cama"></TextInput>
                <InputError :messaje="form.errors.numero_cama" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="estado_cama" value="Estado: "></InputLabel>
                <SelectInput id="estado_cama" :options="['ocupada', 'desocupada']" class="mt-1 block w-3/4"
                    placeholder="Estado"></SelectInput>
                <InputError :messaje="form.errors.estado_cama" class="mt-2"></InputError>
            </div>
            <!-- <div class="p-3">
                <InputLabel for="estado_cama" value="Estado cama: "></InputLabel>
                <TextInput id="estado_cama" ref="estadoInput" v-model="form.estado_cama" type="text"
                    class="mt-1 block w-3/4" placeholder="Estado cama"></TextInput>
                <InputError :messaje="form.errors.estado_cama" class="mt-2"></InputError>
            </div> -->
            <div class="p-3">
                <InputLabel for="sala" value="Sala: "></InputLabel>
                <SelectInput id="sala" :options="sala" v-model="form.sala" class="mt-1 block w-3/4" placeholder="Sala">
                </SelectInput>
                <InputError :messaje="form.errors.sala" class="mt-2"></InputError>
                <!-- <TextInput id="sala_id" ref="salaInput" v-model="form.sala_id" type="text"
                    class="mt-1 block w-3/4" placeholder="Sala"></TextInput>
                <InputError :messaje="form.errors.sala_id" class="mt-2"></InputError> -->
            </div>

            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disabled="form.processing" @click="closeModal">
                    Cancelar
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
