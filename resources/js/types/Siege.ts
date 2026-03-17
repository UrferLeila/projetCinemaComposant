import type { Prix } from './Prix.ts'
import type { Salle } from './Salle.ts'

export interface Siege {
    nom: string;
    prix_type: string;
    salle_id: number;

    prix?: Prix;
    salle?: Salle;

}