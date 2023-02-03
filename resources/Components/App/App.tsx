import React, {Fragment} from 'react';
import {Header} from "../Header/Header";
import {Home} from "../Home/Home";
import styles from './App.module.scss';

export const App: React.FunctionComponent = () => {
    return (
        <Fragment>
            <Header/>
            <div className={styles.main}>
                <Home/>
            </div>
        </Fragment>
    )
        ;
};
