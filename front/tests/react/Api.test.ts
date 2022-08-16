import { describe, expect , it} from "vitest";
import { getName } from "../../src/class/Api";

describe('Test de la classe API', () =>{
    it('Test de la fonction get name'), () => {
        expect(getName(5)).toBe('Et quam laborum voluptates qui molestiae.')
    }

})