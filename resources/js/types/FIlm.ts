import type { Seance } from './Seance.ts'

export interface Film {
    readonly id: number;
    titre: string;
    auteur: string;
    image: string;
    seances?: Seance[];
    readonly created_at?: string;
    readonly updated_at?: string;
}