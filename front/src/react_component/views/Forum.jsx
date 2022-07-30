import React  from 'react'
import{Layout} from './Layout'
import {Container} from '../layouts/Bases/Container'
import {CardContainer} from '../layouts/Bases/CardContainer'
import {ForumTopics} from '../layouts/Topics/ForumTopics'

export function Forum(){
    return <Layout>
                <Container view={['Accueil ', '> Forum']}>
                    <CardContainer CssClass="forum" name='Forum'>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                        <ForumTopics lastInfo='true'/>
                    </CardContainer>
                </Container>
            </Layout>
}