<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, Head } from '@inertiajs/vue3';

const form = useForm({
    nombres_medico: '',
    rut_medico: '',
    apellidoP: '',
});
</script>

<template>
    <Head title="Medicos" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('medicos.store'), { onSuccess: () => form.reset() })"
                class="mt-3 space-y-3 max-w-xl">
                        <InputLabel for="rut_medico" value="RUT"></InputLabel>
                        <TextInput id="rut_medico" v-model="form.rut_medico" autofocus required 
                            type="text"
                            class="mt-1 block w-full">
                        </TextInput>
                        <InputError :message="form.errors.rut_medico" class="mt-2"></InputError>

                        <InputLabel for="nombres_medico" value="Nombres"></InputLabel>
                        <TextInput id="nombres_medico" v-model="form.nombres_medico"
                            type="text"
                            class="mt-1 block w-full">
                        </TextInput>
                        <InputError :message="form.errors.nombres_medico" class="mt-2"></InputError>

                        <InputLabel for="apellidoP" value="Pellido Paterno"></InputLabel>
                        <TextInput id="apellidoP" v-model="form.apellidoP"
                            type="text"
                            class="mt-1 block w-full">
                        </TextInput>
                        <InputError :message="form.errors.apellidoP" class="mt-2"></InputError>

                        <PrimaryButton :disabled="form.processing">
                            <i class="fas fa-save"></i> Guardar
                        </PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
