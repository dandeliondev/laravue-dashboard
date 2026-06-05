<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    form: { type: Object, required: true },
    permissionGroups: { type: Object, required: true },
    submitLabel: { type: String, default: 'Save' },
});

const emit = defineEmits(['submit']);

const colors = ['primary', 'info', 'success', 'warning', 'danger', 'secondary'];

const toggle = (key) => {
    const set = new Set(props.form.permissions);
    set.has(key) ? set.delete(key) : set.add(key);
    props.form.permissions = [...set];
};

const groupKeys = (perms) => Object.keys(perms);
const allInGroup = (perms) => groupKeys(perms).every((k) => props.form.permissions.includes(k));
const toggleGroup = (perms) => {
    const keys = groupKeys(perms);
    const set = new Set(props.form.permissions);
    if (allInGroup(perms)) keys.forEach((k) => set.delete(k));
    else keys.forEach((k) => set.add(k));
    props.form.permissions = [...set];
};
</script>

<template>
    <form @submit.prevent="emit('submit')">
        <div class="row">
            <div class="col-md-6 mb-25">
                <label class="form-label" for="name">Role Name</label>
                <input id="name" v-model="form.name" type="text" class="form-control"
                    :class="{ 'is-invalid': form.errors.name }" placeholder="e.g. Editor" />
                <div v-if="form.errors.name" class="invalid-feedback d-block">{{ form.errors.name }}</div>
            </div>
            <div class="col-md-6 mb-25">
                <label class="form-label" for="color">Badge Color</label>
                <select id="color" v-model="form.color" class="form-control form-select">
                    <option v-for="c in colors" :key="c" :value="c">{{ c }}</option>
                </select>
            </div>
            <div class="col-md-12 mb-25">
                <label class="form-label" for="description">Description</label>
                <input id="description" v-model="form.description" type="text" class="form-control"
                    placeholder="Short summary of what this role can do" />
            </div>
        </div>

        <label class="form-label d-block mb-2">Permissions</label>
        <div class="row">
            <div v-for="(perms, group) in permissionGroups" :key="group" class="col-md-6 mb-25">
                <div class="hx-perm-group">
                    <div class="hx-perm-group__head">
                        <span>{{ group }}</span>
                        <button type="button" class="btn btn-xs btn-outline-light" @click="toggleGroup(perms)">
                            {{ allInGroup(perms) ? 'Clear' : 'Select all' }}
                        </button>
                    </div>
                    <div class="form-check" v-for="(label, key) in perms" :key="key">
                        <input class="form-check-input" type="checkbox" :id="key"
                            :checked="form.permissions.includes(key)" @change="toggle(key)" />
                        <label class="form-check-label" :for="key">{{ label }}</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-2">
            <button type="submit" class="btn btn-primary px-4" :disabled="form.processing">
                <span v-if="form.processing" class="spinner-border spinner-border-sm me-1"></span>{{ submitLabel }}
            </button>
            <Link :href="route('roles.index')" class="btn btn-light px-4">Cancel</Link>
        </div>
    </form>
</template>

<style scoped>
.hx-perm-group {
    border: 1px solid var(--border-color, #e3e6ef);
    border-radius: 8px;
    padding: 14px 16px;
    height: 100%;
}
.hx-perm-group__head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    margin-bottom: 10px;
}
.btn-xs {
    padding: 2px 10px;
    font-size: 12px;
}
</style>
