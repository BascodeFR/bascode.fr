import { expect, it } from "vitest";
import React from 'react'
import {render} from '@testing-library/react'
import {screen} from '@testing-library/dom'
import {Header} from '../../src/react_component/layouts/Bases/Header';


it('renders correctly', () => {
    render(<Header connecte="true"/>)
    const title = screen.getByText('Utilisateur existant ? Se connecter')
    expect(title).toBeInTheDocument();
  })