export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string | null;
}

export interface UserProps extends Pick<User, 'name' | 'email'> {
    avatar?: string | null;
    onOptionsClick?: () => void;
}

export interface AuthData {
    user: User | null;
}