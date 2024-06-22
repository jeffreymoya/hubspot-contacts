import React from "react";

export type Contact = {
    id: string;
    email: string;
    firstName: string;
    lastName: string;
    becameACustomerDate: string;
    becameALeadDate: string;
}


export type ServerError = {
    error: string;
}

export type PaginationProps = {
    initialPage: number;
    itemsPerPage: number;
    items: any[];
};

export type PaginationReturnType = {
    currentPage: number;
    handlePrevPage: () => void;
    handleCurrentPage: (page: number) => void;
    handleNextPage: () => void;
    currentItems: Contact[];
    totalPages: number;
};

export type ContactTableProps = {
    children: React.ReactNode;
    data: Contact[];
};

export type ContainerProps = Omit<ContactTableProps, 'children'>;

export type ContactStat = {
    minDate: string;
    maxDate: string;
    years: string[];
}

export type DateFilterProp = {
    startDate?: string;
    endDate?: string;
}

export type DateFilterCallbackProp = {
    format: (d: string) => any;
}

export type ServerConfig = {
    hubspotAppUrl: string;
    contacts: ContactStat;
};


export type ServerResponse = {
    status?: string;
    error?: string;
};

export type ContactsApiResponse = {
    contacts: Contact[];
    totalCount: number;
    pageCount: number;
};