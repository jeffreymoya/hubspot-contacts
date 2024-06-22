import {NextResponse} from 'next/server';
import query from "@/app/lib/query";
import {ServerConfig} from "@/app/lib/types";
import {NextApiRequest} from "next";

export async function GET(req: NextApiRequest) {
    const response = await query<ServerConfig>(process.env.CONFIGURATION_URL ?? '');
    return NextResponse.json(response);
}