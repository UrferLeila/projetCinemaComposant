import type { Siege } from './Siege.ts'

export interface Prix {
    type: string;
    prix: number;

    sieges?: Siege[];
}