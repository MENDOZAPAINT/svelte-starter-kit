export interface User {
    id: number;
    name: string;
    email: string;
    image_url?: string | null;
}

export interface UserProps extends Pick<User, 'name' | 'email'> {
    image_url?: string | null;
    onOptionsClick?: () => void;
}

export interface AuthData {
    user: User | null;
}