<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import HeaderDropdown from '@/Components/Hexadash/HeaderDropdown.vue';

defineProps({
    dark: { type: Boolean, default: false },
});
const emit = defineEmits(['toggle-sidebar', 'toggle-dark']);

const page = usePage();
const user = computed(() => page.props.auth?.user ?? {});
const initials = computed(() => {
    const n = (user.value.name || '?').trim().split(/\s+/);
    return ((n[0]?.[0] || '') + (n[1]?.[0] || '')).toUpperCase() || 'U';
});

const logout = () => router.post(route('logout'));
</script>

<template>
    <header class="header-top">
        <nav class="navbar navbar-light">
            <div class="navbar-left">
                <div class="logo-area">
                    <Link class="navbar-brand" :href="route('dashboard')">
                        <img class="dark" src="/hexadash/img/logo-dark.png" alt="logo" />
                        <img class="light" src="/hexadash/img/logo-white.png" alt="logo" />
                    </Link>
                    <a href="javascript:;" class="sidebar-toggle" @click.prevent="emit('toggle-sidebar')">
                        <i class="uil uil-bars" style="font-size: 22px"></i>
                    </a>
                </div>
            </div>

            <div class="navbar-right">
                <ul class="navbar-right__menu">
                    <!-- Search -->
                    <li class="nav-search">
                        <form action="/" class="search-form-topMenu" @submit.prevent>
                            <span class="search-icon uil uil-search"></span>
                            <input class="form-control me-sm-2 box-shadow-none" type="search" placeholder="Search..." aria-label="Search" />
                        </form>
                    </li>

                    <!-- Dark mode toggle -->
                    <li class="nav-flag-select">
                        <a href="javascript:;" class="nav-item-toggle" @click.prevent="emit('toggle-dark')" :title="dark ? 'Switch to light mode' : 'Switch to dark mode'">
                            <i class="uil" :class="dark ? 'uil-sun' : 'uil-moon'" style="font-size: 20px"></i>
                        </a>
                    </li>

                    <!-- Notifications -->
                    <li class="nav-notification">
                        <HeaderDropdown>
                            <template #toggle>
                                <i class="uil uil-bell" style="font-size: 20px"></i>
                            </template>
                            <template #menu>
                                <h2 class="dropdown-wrapper__title">Notifications <span class="badge-circle badge-warning ms-1">3</span></h2>
                                <ul>
                                    <li class="nav-notification__single nav-notification__single--unread d-flex flex-wrap">
                                        <div class="nav-notification__type nav-notification__type--primary">
                                            <i class="uil uil-user-plus"></i>
                                        </div>
                                        <div class="nav-notification__details">
                                            <p><span class="subject">New user registered</span></p>
                                            <p><span class="time">just now</span></p>
                                        </div>
                                    </li>
                                    <li class="nav-notification__single nav-notification__single--unread d-flex flex-wrap">
                                        <div class="nav-notification__type nav-notification__type--success">
                                            <i class="uil uil-check-circle"></i>
                                        </div>
                                        <div class="nav-notification__details">
                                            <p><span class="subject">Profile updated</span></p>
                                            <p><span class="time">2 hrs ago</span></p>
                                        </div>
                                    </li>
                                </ul>
                                <Link href="javascript:;" class="dropdown-wrapper__more">See all notifications</Link>
                            </template>
                        </HeaderDropdown>
                    </li>

                    <!-- Author / profile -->
                    <li class="nav-author">
                        <HeaderDropdown wrapper-class="dropdown-wrapper--small">
                            <template #toggle>
                                <span class="hexadash-avatar">{{ initials }}</span>
                                <span class="nav-item__title">{{ user.name }} <i class="las la-angle-down nav-item__arrow"></i></span>
                            </template>
                            <template #menu>
                                <div class="nav-author__info">
                                    <div class="author-img">
                                        <span class="hexadash-avatar hexadash-avatar--lg">{{ initials }}</span>
                                    </div>
                                    <div>
                                        <h6>{{ user.name }}</h6>
                                        <span>{{ user.email }}</span>
                                    </div>
                                </div>
                                <div class="nav-author__options">
                                    <ul>
                                        <li>
                                            <Link :href="route('profile.edit')"><i class="uil uil-user"></i> Profile</Link>
                                        </li>
                                        <li>
                                            <Link :href="route('profile.edit')"><i class="uil uil-setting"></i> Settings</Link>
                                        </li>
                                    </ul>
                                    <a href="javascript:;" class="nav-author__signout" @click.prevent="logout">
                                        <i class="uil uil-sign-out-alt"></i> Sign Out</a>
                                </div>
                            </template>
                        </HeaderDropdown>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<style>
/* Lightweight initials avatar (replaces the template's photo placeholders). */
.hexadash-avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--color-primary, #5f63f2);
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    flex: 0 0 auto;
}
.hexadash-avatar--lg {
    width: 46px;
    height: 46px;
    font-size: 16px;
}
</style>
