import React  from 'react'
import{Layout} from './Layout'
import {Container} from '../layouts/Bases/Container'
import {CardContainer} from '../layouts/Bases/CardContainer'
import {ForumTopics, useFetchApi} from '../layouts/Topics/ForumTopics'

export function Forum(){
    const limit = 10
    return <Layout>
                <Container view={['Accueil ', '> Forum']}>
                    <CardContainer CssClass="forum" name='Forum'>
                        <ForumTopics limit={limit}/>
                    </CardContainer>
                </Container>
            </Layout>
}