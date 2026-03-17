import type { Reservation } from './Reservation.ts'

export interface User {
    readonly id: number;
    name: string;
    email: string;

    email_verified_at?: string;

    reservations?: Reservation[];

    readonly created_at?: string;
    readonly updated_at?: string;
}