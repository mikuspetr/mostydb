<template>
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
                    :close-on-select="false"
                    :clear-on-select="false"
                    :preserve-search="true"
                    placeholder="Vyberte klienty"
                    label="clientCode"
                    track-by="id"
                    />


                <label for="users" class="form-label">Pracovníci</label>
                <multiselect
                    v-model="form.users"
                    :options="userNames"
                    :multiple="true"
                    :close-on-select="false"
                    :clear-on-select="false"
                    :preserve-search="true"
                    placeholder="Vyberte pracovníky"
                    label="login"
                    track-by="id"
                    />
                <input
                    v-for="userId in selectedUserIds"
                    :key="`user-hidden-${userId}`"
                    type="hidden"
                    name="users[]"
                    :value="userId"
                >
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

                <TextArea :id="'int-text'" :modelValue="form.text" name="text" class="form-control" rows="10" v-model="form.text"></TextArea>
                <input type="hidden" name="text" :value="form.text">

            </div>
        </div>

</template>

<script setup>
import { reactive, computed, ref } from 'vue'

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
    recordClients: {
        type: Array,
        default: () => [],
    },
})
const clientCodes = computed(() =>
    props.clients.map(c => ({
        id: c.id,
        clientCode: c.clientCode ?? c.client_code,
    }))
)
const userNames = computed(() =>
    props.users.map(u => ({
        id: u.id,
        login: u.login,
    }))
)
const selectedClientIds = computed(() =>
    (form.clients ?? [])
        .map(client => (typeof client === 'object' ? client.id : client))
        .filter(clientId => clientId !== null && clientId !== undefined && clientId !== '')
)
const selectedUserIds = computed(() =>
    (form.users ?? [])
        .map(user => (typeof user === 'object' ? user.id : user))
        .filter(userId => userId !== null && userId !== undefined && userId !== '')
)

const form = reactive({
    date: props.record?.date ?? new Date().toISOString().slice(0, 10),
    place_id: props.record?.place_id ?? (props.places[0]?.id ?? null),
    clients: props.recordClients ?? [],
    users: props.record?.users?.map(u => u.login) ?? [],
    duration: props.record?.duration ?? '',
    duration_pp: props.record?.duration_pp ?? '',
    form_id: props.record?.form_id ?? (props.recordForms[0]?.id ?? null),
    type_id: props.record?.type_id ?? (props.recordTypes[0]?.id ?? null),
    color_id: props.record?.color_id ?? '',
    text: props.record?.text ?? '',
});

const isSubmitting = ref(false)

const handleSubmit = () => {
    isSubmitting.value = true
}

const mounted = () => {
    console.log('Mounted RecordGroupForm, clients:', props.clients);
    //clientCodes.value = props.clients.map(c => c.client_code);
}
</script>
