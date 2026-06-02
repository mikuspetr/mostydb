<template>
	<div>
		<multiselect
			:id="id"
			v-model="selectedValue"
			:options="options"
			:multiple="multiple"
			:track-by="trackBy"
			:label="label"
			:placeholder="placeholder"
			:searchable="searchable"
			:close-on-select="closeOnSelect"
			:allow-empty="allowEmpty"
			:disabled="disabled"
		/>

		<template v-if="name">
			<input
				v-for="(value, index) in normalizedValues"
				:key="`${name}-${index}-${String(value)}`"
				type="hidden"
				:name="inputName"
				:value="value"
			>
		</template>
	</div>
</template>

<script setup>

const props = defineProps({
	id: {
		type: String,
		default: '',
	},
	modelValue: {
		type: [Array, Object, String, Number, Boolean],
		default: null,
	},
	options: {
		type: Array,
		default: () => [],
	},
	name: {
		type: String,
		default: '',
	},
	multiple: {
		type: Boolean,
		default: false,
	},
	trackBy: {
		type: String,
		default: '',
	},
	label: {
		type: String,
		default: '',
	},
	valueKey: {
		type: String,
		default: '',
	},
	placeholder: {
		type: String,
		default: '',
	},
	searchable: {
		type: Boolean,
		default: true,
	},
	closeOnSelect: {
		type: Boolean,
		default: true,
	},
	allowEmpty: {
		type: Boolean,
		default: true,
	},
	disabled: {
		type: Boolean,
		default: false,
	},
})

const emit = defineEmits(['update:modelValue'])

const selectedValue = computed({
	get: () => props.modelValue,
	set: (value) => emit('update:modelValue', value),
})

const inputName = computed(() => {
	if (!props.name) {
		return ''
	}

	return props.multiple && !props.name.endsWith('[]')
		? `${props.name}[]`
		: props.name
})

const toHiddenValue = (item) => {
	if (item === null || item === undefined) {
		return ''
	}

	if (props.valueKey && typeof item === 'object') {
		return item[props.valueKey] ?? ''
	}

	return item
}

const normalizedValues = computed(() => {
	if (props.multiple) {
		return Array.isArray(props.modelValue)
			? props.modelValue.map(toHiddenValue)
			: []
	}

	if (props.modelValue === null || props.modelValue === undefined || props.modelValue === '') {
		return []
	}

	return [toHiddenValue(props.modelValue)]
})
</script>
