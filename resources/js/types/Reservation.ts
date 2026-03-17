import type { User } from './User.ts'
import type { Seance } from './Seance.ts'
import type { ReservationSiege } from './ReservationSiege.ts'

export interface Reservation {
    readonly id: number;
    user_id: number;
    seance_id: number;

    user?: User;
    seance?: Seance;
    reservationSieges?: ReservationSiege[];

    total_price?: number;

    readonly created_at?: string;
    readonly updated_at?: string;
}