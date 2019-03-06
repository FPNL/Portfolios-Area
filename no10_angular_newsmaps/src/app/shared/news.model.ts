export class News {
  constructor(
    public labels: string,
    public content: string,
    public imagePath: string,
    public time: {
      add: number,
      edit?: number[]
    },
    public title: string,
    public user: UserInterface,
    public info: InfoInterface,
    public id?: string,
    public tags?: string[],
  ) {}
}
export interface UserInterface {
  account: string;
  firstname?: string;
  lastname?: string;
  nickname?: string;
  avatarPath?: string;
  articles?: string[];
  password?: string;
}
export interface InfoInterface {
  location: {
    latitude: number;
    longitude: number;
  };
  readers: number;
  star: {
    point: number;
    reviewer?: string[];
    reviewers?: {
      account: string;
      point: number;
    }[]
  };
}
