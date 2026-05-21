<template>
    <form method="POST" :action="record ? updateRoute : storeRoute">
        <input type="hidden" name="_token" :value="csrfToken">
        <input v-if="record" type="hidden" name="_method" value="PUT">

        <div class="row">
            <div class="col-sm-3">
                <label for="date" class="form-label mt-0">Datum</label>
                <input
                    type="date"
                    name="date"
                    v-model="form.date"
                    id="date"
                    class="form-control"
                    required
                >

                <label class="form-label">Místo</label><br>
                <label v-for="(place, index) in places" :key="place.id" :class="index > 0 ? 'ms-3' : ''">
                    <input
                        type="radio"
                        name="place_id"
                        :value="place.id"
                        class="form-check-input"
                        v-model="form.place_id"
                    >
                    {{ place.name }}
                </label>
                <br>

                <label for="clients" class="form-label">Klient</label>
                <multiselect
                    v-model="form.clients"
                    :options="clientCodes"
                    :multiple="true"
                />
                <input
                    v-for="client in form.clients"
                    :key="client"
                    type="hidden"
                    name="clients[]"
                    :value="client"
                >

                <label for="users" class="form-label">Pracovníci</label>
                <select name="users[]" id="users" class="form-select" multiple v-model="form.users">
                    <option v-for="user in users" :key="user.id" :value="user.id">
                        {{ user.login }}
                    </option>
                </select>
                <br>
                <hr>
                <div class="row">
                    <div class="col">
                        <label for="duration" class="form-label">Čas intervence</label>
                        <select name="duration" id="duration" class="form-select" v-model="form.duration">
                            <option v-for="(label, value) in groupDurations" :key="value" :value="value">
                                {{ label }}
                            </option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="duration_pp" class="form-label">Čas přímé péče</label>
                        <select name="duration_pp" id="duration_pp" class="form-select" v-model="form.duration_pp">
                            <option v-for="(label, value) in groupDurations" :key="value" :value="value">
                                {{ label }}
                            </option>
                        </select>
                    </div>
                </div>

                <label class="form-label">Forma intervence</label><br>
                <label v-for="(recordForm, index) in recordForms" :key="recordForm.id" :class="index > 0 ? 'ms-3' : ''">
                    <input
                        type="radio"
                        name="form_id"
                        :value="recordForm.id"
                        class="form-check-input"
                        v-model="form.form_id"
                    >
                    {{ recordForm.name }}
                </label>
                <br>

                <label class="form-label">Typ intervence</label><br>
                <label v-for="(type, index) in recordTypes" :key="type.id" :class="index > 0 ? 'ms-3' : ''">
                    <input
                        type="radio"
                        name="type_id"
                        :value="type.id"
                        class="form-check-input"
                        v-model="form.type_id"
                    >
                    {{ type.name }}
                </label>
                <br>

                <label class="form-label">Označení ve výpisu</label><br>
                <label>
                    <input
                        type="radio"
                        name="color_id"
                        value=""
                        class="form-check-input"
                        v-model="form.color_id"
                    >
                    Žádné
                </label>
                <label v-for="color in recordColors" :key="color.id" class="ms-3" :style="{ color: color.color }">
                    <input
                        type="radio"
                        name="color_id"
                        :value="color.id"
                        class="form-check-input"
                        v-model="form.color_id"
                    >
                    {{ color.name }}
                </label>
                <br>
            </div>

            <div class="col-sm-8">
                <label for="text">Text intervence</label>
                <textarea name="text" id="text" class="ckeditor" v-model="form.text"></textarea>
            </div>

            <div class="col-sm-4"></div>
        </div>

        <input type="hidden" name="kind_id" value="2">
        <input type="hidden" name="intervention" value="1">
        <button type="submit" class="btn btn-primary mt-3">
            {{ record ? 'Upravit skupinovou intervenci' : 'Přidat skupinovou intervenci' }}
        </button>
    </form>
</template>

<script setup>
import { reactive, computed } from 'vue'
import VueMultiselect from 'vue-multiselect'

const props = defineProps({
    record: {
        type: Object,
        default: null,
    },
    places: {
        type: Array,
        default: () => [],
    },
    clients: {
        type: Array,
        default: () => [],
    },
    users: {
        type: Array,
        default: () => [],
    },
    groupDurations: {
        type: Object,
        default: () => ({}),
    },
    recordForms: {
        type: Array,
        default: () => [],
    },
    recordTypes: {
        type: Array,
        default: () => [],
    },
    recordColors: {
        type: Array,
        default: () => [],
    },
    storeRoute: {
        type: String,
        required: true,
    },
    updateRoute: {
        type: String,
        default: '',
    },
    csrfToken: {
        type: String,
        required: true,
    },
})

const clientCodes = computed(() => props.clients.map(c => c.clientCode))

const form = reactive({
    date: props.record?.date ?? new Date().toISOString().slice(0, 10),
    place_id: props.record?.place_id ?? (props.places[0]?.id ?? null),
    clients: props.record?.clients?.map(c => c.client_code) ?? [],
    users: props.record?.users?.map(u => u.id) ?? [],
    duration: props.record?.duration ?? '',
    duration_pp: props.record?.duration_pp ?? '',
    form_id: props.record?.form_id ?? (props.recordForms[0]?.id ?? null),
    type_id: props.record?.type_id ?? (props.recordTypes[0]?.id ?? null),
    color_id: props.record?.color_id ?? '',
    text: props.record?.text ?? '',
});

const mounted = () => {
    console.log('Mounted RecordGroupForm, clients:', props.clients);
    //clientCodes.value = props.clients.map(c => c.client_code);
}
</script>
