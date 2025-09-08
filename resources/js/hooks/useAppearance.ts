import { writable } from 'svelte/store';
import { onMount } from 'svelte';

export type Appearance = 'light' | 'dark' | 'system';

export function updateTheme(value: Appearance) {
  if (typeof window === 'undefined') {
    return;
  }

  if (value === 'system') {
    const mediaQueryList = window.matchMedia('(prefers-color-scheme: dark)');
    const systemTheme = mediaQueryList.matches ? 'dark' : 'light';

    document.documentElement.classList.toggle('dark', systemTheme === 'dark');
  } else {
    document.documentElement.classList.toggle('dark', value === 'dark');
  }
}

const setCookie = (name: string, value: string, days = 365) => {
  if (typeof document === 'undefined') {
    return;
  }

  const maxAge = days * 24 * 60 * 60;

  document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
};

const mediaQuery = () => {
  if (typeof window === 'undefined') {
    return null;
  }

  return window.matchMedia('(prefers-color-scheme: dark)');
};

const getStoredAppearance = () => {
  if (typeof window === 'undefined') {
    return null;
  }

  return localStorage.getItem('appearance') as Appearance | null;
};

const handleSystemThemeChange = () => {
  const currentAppearance = getStoredAppearance();

  updateTheme(currentAppearance || 'system');
};

export function initializeTheme() {
  if (typeof window === 'undefined') {
    return;
  }

  // Initialize theme from saved preference or default to system...
  const savedAppearance = getStoredAppearance();
  updateTheme(savedAppearance || 'system');

  // Set up system theme change listener...
  mediaQuery()?.addEventListener('change', handleSystemThemeChange);
}

// Svelte store for appearance
export const appearance = writable<Appearance>('system');

export function createAppearanceStore() {
  const { subscribe, set } = writable<Appearance>('system');

  return {
    subscribe,
    init: () => {
      if (typeof window === 'undefined') return;

      const savedAppearance = localStorage.getItem('appearance') as Appearance | null;
      if (savedAppearance) {
        set(savedAppearance);
      }
    },
    updateAppearance: (value: Appearance) => {
      set(value);

      if (typeof window === 'undefined') return;

      // Store in localStorage for client-side persistence...
      localStorage.setItem('appearance', value);

      // Store in cookie for SSR...
      setCookie('appearance', value);

      updateTheme(value);
    }
  };
}

// Alternative composable-style function (similar to Vue's useAppearance)
export function useAppearance() {
  const store = createAppearanceStore();

  // Initialize on mount
  onMount(() => {
    store.init();
  });

  return store;
}