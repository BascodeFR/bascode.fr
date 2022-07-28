import ReactDOM from 'react-dom/client'
import CardContainer from '../layouts/card_container'
import ForumTopics from '../layouts/topics/forum'
import Actu from '../layouts/actu'
import Container from '../layouts/container'
import ActuContainer from '../layouts/actu_container'
import Layout from './layout'


ReactDOM.createRoot(document.getElementById('root')).render(
    <Layout>
        <Container view='Accueil'>
            <CardContainer className="last-topics" name='Derniers Topics'>
                <ForumTopics lastInfo='true' />
                <ForumTopics lastInfo='true' />
                <ForumTopics lastInfo='true' />
                <ForumTopics lastInfo='true' />
                <ForumTopics lastInfo='true' />
            </CardContainer>
            <CardContainer className="last-actu" name='Dernières Actualités'>
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
            <CardContainer className="last-topics" name='Derniers Tutoriels'>
                <ForumTopics lastInfo='false' />
            </CardContainer>
        </Container>
    </Layout>
)