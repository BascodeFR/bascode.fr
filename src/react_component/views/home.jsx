import {CardContainer} from '../layouts/Bases/CardContainer'
import {ForumTopics} from '../layouts/Topics/ForumTopics'
import {Actu} from '../layouts/Actu/Actu'
import {Container} from '../layouts/Bases/Container'
import {ActuContainer} from '../layouts/Actu/ActuContainer'
import {Layout} from './Layout'

export function Home(){
    return <Layout>
                <Container view={['Accueil']}>
                    <CardContainer CssClass="last-topics" name='Derniers Topics'>
                        <ForumTopics lastInfo='true' />
                        <ForumTopics lastInfo='true' />
                        <ForumTopics lastInfo='true' />
                        <ForumTopics lastInfo='true' />
                        <ForumTopics lastInfo='true' />
                    </CardContainer>
                    <CardContainer CssClass="last-actu" name='Dernières Actualités'>
                        <ActuContainer>
                            <Actu />
                            <Actu />
                            <Actu />
                            <Actu />
                            <Actu />
                            <Actu />
                            <Actu />
                            <Actu />
                            <Actu />
                            <Actu />
                        </ActuContainer>
                    </CardContainer>
                    <CardContainer CssClass="last-topics" name='Derniers Tutoriels'>
                        <ForumTopics lastInfo='false' />
                    </CardContainer>
                </Container>
            </Layout>

}
    