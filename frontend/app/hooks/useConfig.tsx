'use client';
import {useEffect, useState} from 'react';
import {ServerConfig} from "@/app/lib/types";
import query from "@/app/lib/query";

const useConfig = (): ServerConfig => {
    const [config, setConfig] = useState<ServerConfig>({ contacts: { maxDate: '', minDate: '', years: [] }, hubspotAppUrl: '' })

    useEffect(() => {
        (async () => {
            const res = await query<ServerConfig>('/api/config');
            if(res) {
                setConfig(res);
            }
        })();

    }, []);

    return config;
};

export default useConfig;