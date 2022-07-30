
import { describe, expect , it} from "vitest";
import React from 'react'
import {render} from '@testing-library/react'
import {screen} from '@testing-library/dom'
import { Header } from "../../src/react_component/layouts/Bases/Header";


describe('Header render tests', () =>{
  it('renders Header without connect correctly', function () {
    render(<Header connecte="false"/>)
    const title = screen.getByText('Utilisateur existant ? Se connecter')
    // @ts-ignore
    expect(title).toBeInTheDocument();
  })

  it('renders Header with connect correctly', () => {
    render(<Header connecte="true"/>)
    const title = screen.getByText('Cavernos')
    // @ts-ignore
    expect(title).toBeInTheDocument();
  })

})
