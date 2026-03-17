import type { Reservation } from './Reservation.ts'
import type { Siege } from './Siege.ts'

export interface ReservationSiege {
    readonly id: number;
    reservation_id: number;
    siege_nom: string;

    reservation?: Reservation;
    siege?: Siege;
}