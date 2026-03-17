import type { Film } from './Film.ts'
import type { Salle } from './Salle.ts'
import type { Reservation } from './Reservation.ts'

export interface Seance {
    readonly id: number;
    date: string;
    heure: string;
    salle_id: number;
    film_id: number;

    film?: Film;
    salle?: Salle;
    reservations?: Reservation[];

    readonly created_at?: string;
    readonly updated_at?: string;
}